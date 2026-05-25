<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SensorData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // WAJIB DI-IMPORT untuk mengunci waktu lokal

class SensorController extends Controller
{
    public function store(Request $request)
    {
        // 1. VALIDASI DATA DARI ESP8266 (Disamakan dengan skrip hardware terbaru)
        $validated = $request->validate([
            'token' => 'required|string',
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'fan_status' => 'required|string|in:ON,OFF',
            'humidifier_status' => 'required|string|in:ON,OFF',
        ]);

        // 2. CARI USER BERDASARKAN TOKEN
        $user = User::where('token', $validated['token'])->first();

        // Jika token tidak ditemukan
        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid!',
            ], 401);
        }

        // 3. KUNCI MATI WAKTU JAKARTA (GMT+7)
        // Ini akan mem-bypass setingan sistem luar dan memaksa waktu lokal masuk ke SQLite
        $waktuLokal = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

        // 4. SIMPAN DATA SENSOR KEDALAM DATABASE SQLite
        $sensor = SensorData::create([
            'user_id' => $user->id,
            'temperature' => $validated['temperature'],
            'humidity' => $validated['humidity'],
            'fan_status' => $validated['fan_status'],
            'humidifier_status' => $validated['humidifier_status'],
            'created_at' => $waktuLokal, // Paksa timpa waktu UTC bawaan menjadi WIB
            'updated_at' => $waktuLokal, // Paksa timpa waktu UTC bawaan menjadi WIB
        ]);

        // 5. RESPONSE SUKSES BALIK KE ESP8266
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'time' => $waktuLokal, // Menampilkan jam lokal di serial monitor ESP jika dibutuhkan
            'data' => $sensor,
        ], 201);
    }
}
