<?php

namespace App\Http\Controllers;

use App\Models\Device; // Mengimpor Model agar tidak error "Class not found"
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'device_name' => 'required|string|max:255',
        ]);

        // 2. Simpan ke database
        $device = Device::create([
            'user_id'     => 14, 
            'device_name' => $request->device_name,
            'api_key'     => Str::random(32),
        ]);

        // 3. Respon
        return response()->json([
            'message' => 'Device berhasil dibuat',
            'data'    => $device
        ], 201);
    }
}