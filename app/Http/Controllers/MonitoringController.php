<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
<<<<<<< HEAD
=======
use Illuminate\Pagination\LengthAwarePaginator;
>>>>>>> 1e277a65e8691eac062f6adb3e50918c8c95f866
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Proteksi Admin: Admin tidak boleh masuk ke halaman ini
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index');
        }

        // 2. Ambil semua ID device milik user
        $deviceIds = $user->devices()->pluck('id');

        // 3. PENGAMAN: Jika user baru belum memiliki device
        if ($deviceIds->isEmpty()) {
            return view('monitoring', [
                'latest' => null,
                'warehouseStatus' => 'BELUM TERDAFTAR',
                'history' => new LengthAwarePaginator([], 0, 10),
                'chartData' => collect(),
                'filter' => $request->status,
                // Kirim pesan error untuk ditampilkan di Blade
                'error_message' => 'Akun Anda belum dikaitkan dengan perangkat IoT. Silakan hubungi Admin untuk aktivasi.',
            ]);
        }

        // 4. Logika normal untuk User yang sudah memiliki device
        $latest = SensorData::whereIn('device_id', $deviceIds)->latest()->first();

        $chartData = SensorData::whereIn('device_id', $deviceIds)
            ->latest()
            ->take(15)
            ->get()
            ->reverse();

        $warehouseStatus = 'STANDBY';
        if ($latest) {
            $warehouseStatus = ($latest->temperature > 30 || $latest->humidity > 85) ? 'TIDAK AMAN' : 'AMAN';
        }

        $query = SensorData::whereIn('device_id', $deviceIds)->latest();
        $filter = $request->status;

<<<<<<< HEAD
        if ($filter == 'aman') {
            $query->where('temperature', '<=', 25)
                ->where('humidity', '<=', 95);
        } elseif ($filter == 'tidak_aman') {
            $query->where(function ($q) {
                $q->where('temperature', '>', 25)
                    ->orWhere('humidity', '>', 95);
            });
        }
=======
       if ($filter == 'aman') {
>>>>>>> 1e277a65e8691eac062f6adb3e50918c8c95f866

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
            'history' => $query->paginate(10),
            'chartData' => $chartData,
            'filter' => $filter,
<<<<<<< HEAD
=======
            'error_message' => null, // Tidak ada error
>>>>>>> 1e277a65e8691eac062f6adb3e50918c8c95f866
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $user = Auth::user();

<<<<<<< HEAD
        if ($filter == 'aman') {
            $query->where('temperature', '<=', 30)
                ->where('humidity', '<=', 85);
        } elseif ($filter == 'tidak_aman') {
            $query->where(function ($q) {
                $q->where('temperature', '>', 30)
                    ->orWhere('humidity', '>', 85);
            });
=======
        // Proteksi download bagi admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index');
>>>>>>> 1e277a65e8691eac062f6adb3e50918c8c95f866
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
<<<<<<< HEAD
            'filter' => $filter,
            'user' => Auth::user(),
=======
            'filter' => $request->status,
            'user' => $user,
>>>>>>> 1e277a65e8691eac062f6adb3e50918c8c95f866
        ]);

        return $pdf->download("AgroMonitor_Report_{$date}.pdf");
    }
<<<<<<< HEAD
=======

    public function storeSensorData(Request $request)
    {
        // Cari perangkat berdasarkan token yang dikirim ESP8266
        $device = DeviceModel::where('token', $request->token)->first();

        if (! $device) {
            return response()->json(['message' => 'Token Tidak Dikenali'], 403);
        }

        // Simpan data
        SensorData::create([
            'device_id' => $device->id,
            'temperature' => $request->temperature,
            'humidity' => $request->humidity,
        ]);

        return response()->json(['message' => 'Data Diterima'], 200);
    }
>>>>>>> 1e277a65e8691eac062f6adb3e50918c8c95f866
}
