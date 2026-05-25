<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    // Daftarkan kolom yang boleh diisi data
    protected $fillable = ['device_name', 'api_key', 'user_id'];

    // Hubungkan Device balik ke User (Satu device hanya dimiliki oleh satu user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hubungkan Device ke Data Sensor (Satu device punya banyak data sensor)
    public function sensorData()
    {
        // Kita pakai nama tabel kamu 'sensor_data' dan foreign key 'device_id'
        return $this->hasMany(SensorData::class, 'device_id');
    }
}