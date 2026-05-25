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

    protected static function booted()
    {
        // Sebelum data disimpan (creating), paksa set waktu ke Jakarta
        static::creating(function ($model) {
            $waktuLokal = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
            $model->created_at = $waktuLokal;
            $model->updated_at = $waktuLokal;
        });
    }

    // Relasi balik: Data sensor ini milik device yang mana?
    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
