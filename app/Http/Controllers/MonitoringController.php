<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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
            $warehouseStatus = ($latest->temperature > 30 || $latest->humidity > 85)
                ? 'TIDAK AMAN'
                : 'AMAN';
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

        // Proteksi download bagi admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index');
        }

        $deviceIds = $user->devices()->pluck('id');

        if ($deviceIds->isEmpty()) {
            return redirect()->back()->with('error', 'Gagal mengunduh laporan. Anda belum memiliki perangkat terdaftar.');
        }

        $query = SensorData::whereIn('device_id', $deviceIds)->latest();

        // ... (Logika filter PDF tetap sama)
        $history = $query->get();
        $date = now()->format('d-m-Y_H-i');

        $pdf = Pdf::loadView('emails.monitoring-pdf', [
            'history' => $history,
            'filter' => $request->status,
            'user' => $user,
        ]);

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
