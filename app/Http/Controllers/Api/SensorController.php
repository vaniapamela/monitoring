<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorController extends Controller
{
    
    public function store(Request $request)
{
    $request->validate([
        'temperature' => 'required|numeric',
        'humidity' => 'required|numeric'
    ]);

    $temperature = $request->temperature;
    $humidity = $request->humidity;

    $fanStatus = 'OFF';

    // Otomatis nyalakan fan jika suhu > 20
    if ($temperature > 20) {
        $fanStatus = 'ON';
    }

    SensorData::create([
        'temperature' => $temperature,
        'humidity' => $humidity,
        'fan_status' => $fanStatus
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Data sensor berhasil disimpan',
        'data' => [
            'temperature' => $temperature,
            'humidity' => $humidity,
            'fan_status' => $fanStatus
        ]
    ]);
}
}