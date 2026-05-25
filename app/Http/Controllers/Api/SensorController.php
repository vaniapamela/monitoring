<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SensorData;
use App\Models\User;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data dari ESP8266
        $request->validate([
            'token' => 'required|string',
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
        ]);

        // Cari user berdasarkan token
        $user = User::where(
            'token',
            $request->token
        )->first();

        // Jika token tidak ditemukan
        if (!$user) {

            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid!',
            ], 401);
        }

        // Simpan data sensor
        $sensor = SensorData::create([
            'user_id' => $user->id,
            'temperature' => $request->temperature,
            'humidity' => $request->humidity,
        ]);

        // Response sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'data' => $sensor,
        ], 201);
    }
}