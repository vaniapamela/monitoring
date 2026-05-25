<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\SensorData;

class SensorController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input data dari ESP8266
        $request->validate([
            'api_key'     => 'required|string',
            'temperature' => 'required|numeric',
            'humidity'    => 'required|numeric',
        ]);

        // 2. Cek apakah api_key yang dikirim ESP8266 terdaftar di tabel devices
        $device = Device::where('api_key', $request->api_key)->first();

        // 3. Jika API Key tidak ditemukan, tolak akses (Kembalikan status 401 Unauthorized)
        if (!$device) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized: API Key salah atau tidak terdaftar!'
            ], 401);
        }

        // 4. Jika valid, simpan data ke tabel sensor_data dan ikat dengan device_id-nya
        $sensor = SensorData::create([
            'device_id'   => $device->id,
            'temperature' => $request->temperature,
            'humidity'    => $request->humidity,
        ]);

        // 5. Beri respon sukses ke ESP8266
        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil disimpan untuk device: ' . $device->device_name,
            'data'    => $sensor
        ], 201);
    }
}