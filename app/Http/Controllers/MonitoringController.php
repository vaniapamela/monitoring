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
        $userId = Auth::id();

        // Mengambil data terbaru spesifik milik user yang login
        $latest = SensorData::where('user_id', $userId)->latest()->first();

        // Data Chart (10 data terakhir, dibalik agar urutan waktu dari kiri ke kanan)
        $chartData = SensorData::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get()
            ->reverse();

        $warehouseStatus = 'STANDBY';

        if ($latest) {
            if ($latest->temperature > 30 || $latest->humidity > 85) {
                $warehouseStatus = 'TIDAK AMAN';
            } else {
                $warehouseStatus = 'AMAN';
            }
        }

        // Mulai kueri riwayat berdasarkan user_id
        $query = SensorData::where('user_id', $userId)->latest();
        $filter = $request->status;

        if ($filter == 'aman') {
            $query->where('temperature', '<=', 25)
                ->where('humidity', '<=', 95);
        } elseif ($filter == 'tidak_aman') {
            $query->where(function ($q) {
                $q->where('temperature', '>', 25)
                    ->orWhere('humidity', '>', 95);
            });
        }

        $history = $query->take(50)->get(); // Mengambil maksimal 50 riwayat untuk efisiensi halaman

        return view('monitoring', [
            'latest' => $latest,
            'warehouseStatus' => $warehouseStatus,
            'history' => $history,
            'chartData' => $chartData,
            'filter' => $filter,
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $userId = Auth::id();
        $query = SensorData::where('user_id', $userId)->latest();
        $filter = $request->status;

        if ($filter == 'aman') {
            $query->where('temperature', '<=', 30)
                ->where('humidity', '<=', 85);
        } elseif ($filter == 'tidak_aman') {
            $query->where(function ($q) {
                $q->where('temperature', '>', 30)
                    ->orWhere('humidity', '>', 85);
            });
        }

        $history = $query->get();
        $date = now()->format('d-m-Y_H-i');

        $pdf = Pdf::loadView('emails.monitoring-pdf', [
            'history' => $history,
            'filter' => $filter,
            'user' => Auth::user(),
        ]);

        return $pdf->download("AgroMonitor_Report_{$filter}_{$date}.pdf");
    }
}
