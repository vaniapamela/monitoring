<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $latest = SensorData::latest()->first();

        $chartData = SensorData::latest()
            ->take(10)
            ->get()
            ->reverse();

        $warehouseStatus = 'STANDBY';

        if ($latest) {

            if (
                $latest->temperature > 30 ||
                $latest->humidity > 85
            ) {

                $warehouseStatus = 'TIDAK AMAN';

            } else {

                $warehouseStatus = 'AMAN';
            }
        }

        $query = SensorData::latest();

        $filter = $request->status;

        if ($filter == 'aman') {

            $query->where('temperature', '<=', 20)
                  ->where('humidity', '<=', 90);

        } elseif ($filter == 'tidak_aman') {

            $query->where(function ($q) {

                $q->where('temperature', '>', 20)
                  ->orWhere('humidity', '>', 90);

            });
        }

        $history = $query->take(10)->get();

        return view('monitoring', [
            'latest' => $latest,
            'warehouseStatus' => $warehouseStatus,
            'history' => $history,
            'chartData' => $chartData,
            'filter' => $filter
        ]);
    }
}