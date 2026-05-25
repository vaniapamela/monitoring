<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index');
        }

        // Ambil semua data sensor langsung (tanpa device)
        $latest = SensorData::latest()->first();

        $chartData = SensorData::latest()
            ->take(15)
            ->get()
            ->reverse();

        $warehouseStatus = 'STANDBY';

        if ($latest) {
            $warehouseStatus = ($latest->temperature <= 25 && $latest->humidity <= 90)
                ? 'AMAN'
                : 'TIDAK AMAN';
        }

        $query = SensorData::latest();
        $filter = $request->status;

        if ($filter == 'aman') {
            $query->whereBetween('temperature', [20, 25])
                ->whereBetween('humidity', [60, 90]);

        } elseif ($filter == 'tidak_aman') {
            $query->where(function ($q) {
                $q->where('temperature', '<', 20)
                    ->orWhere('temperature', '>', 25)
                    ->orWhere('humidity', '<', 60)
                    ->orWhere('humidity', '>', 90);
            });
        }

        return view('monitoring', [
            'latest' => $latest,
            'warehouseStatus' => $warehouseStatus,
            'history' => $query->paginate(10)->withQueryString(),
            'chartData' => $chartData,
            'filter' => $filter,
            'error_message' => null,
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $user = Auth::user();

        // 1. Proteksi download bagi admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index');
        }

        // 2. QUERY LANGSUNG BERDASARKAN user_id (Sesuai Struktur Baru)
        $query = SensorData::where('user_id', $user->id)->latest();

        // 3. LOGIKA FILTER DATA SENSOR (Sama dengan filter halaman dashboard utama)
        $filter = $request->status;
        if ($filter == 'aman') {
            $query->whereBetween('temperature', [20, 25])
                ->whereBetween('humidity', [60, 90]);
        } elseif ($filter == 'tidak_aman') {
            $query->where(function ($q) {
                $q->where('temperature', '<', 20)
                    ->orWhere('temperature', '>', 25)
                    ->orWhere('humidity', '<', 60)
                    ->orWhere('humidity', '>', 90);
            });
        }

        // 4. Ambil data hasil filter
        $history = $query->get();

        // 5. Cek apakah ada data untuk dicetak agar PDF tidak kosong sia-sia
        if ($history->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data sensor yang tersedia untuk dicetak dengan filter ini.');
        }

        // 6. Set stempel waktu nama file menggunakan waktu lokal Jakarta
        $date = Carbon::now('Asia/Jakarta')->format('d-m-Y_H-i');

        // 7. Render view menjadi file PDF
        $pdf = Pdf::loadView('emails.monitoring-pdf', [
            'history' => $history,
            'filter' => $filter,
            'user' => $user,
        ]);

        // 8. Kirim file PDF hasil unduhan ke browser user
        return $pdf->download("AgroMonitor_Report_{$date}.pdf");
    }

    public function storeSensorData(Request $request)
    {
        // Cari perangkat berdasarkan token yang dikirim ESP8266
        $device = DeviceModel::where('token', $request->token)->first();

        if (! $device) {
            return response()->json(['message' => 'Token Tidak Dikenali'], 403);
        }

        // 2. Ambil waktu Jakarta detik ini juga
        $waktuLokal = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

        // 3. Masukkan ke database dengan memaksa created_at & updated_at pake waktu lokal
        $sensor = SensorData::create([
            'temperature' => $validated['temperature'],
            'humidity' => $validated['humidity'],
            'fan_status' => $validated['fan_status'],
            'created_at' => $waktuLokal, // Paksa timpa created_at
            'updated_at' => $waktuLokal, // Paksa timpa updated_at
        ]);

        return response()->json(['message' => 'Data Diterima'], 200);
    }
}
