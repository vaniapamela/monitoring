<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    // Pastikan nama tabelnya sesuai dengan di phpMyAdmin
    protected $table = 'sensor_data';

    // Tambahkan 'device_id' ke dalam fillable agar bisa disimpan nanti
    protected $fillable = ['temperature', 'humidity', 'device_id', 'created_at', 'updated_at'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    // Relasi balik: Data sensor ini milik device yang mana?
    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
