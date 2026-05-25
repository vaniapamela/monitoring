<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    // Nama tabel didefinisikan secara eksplisit (Best Practice)
    protected $table = 'sensor_data';

    /**
     * Properti yang diizinkan untuk mass-assignment.
     * Wajib menyertakan semua kolom yang dikirim dari Controller ke Database.
     */
    protected $fillable = [
        'user_id',            // Menggantikan device_id agar sinkron dengan Controller & Migration
        'temperature',
        'humidity',
        'fan_status',         // Wajib ada agar status Kipas bisa tersimpan
        'humidifier_status',  // Wajib ada agar status Humidifier bisa tersimpan
        'created_at',         // Diperlukan karena kita memaksa override waktu GMT+7
        'updated_at',          // Diperlukan karena kita memaksa override waktu GMT+7
    ];

    /**
     * OPTIMASI: Casting tipe data saat dibaca di Blade / API
     * Ini memastikan waktu dibaca sebagai string tanggal yang rapi, bukan object mentah.
     */
    protected $casts = [
        'temperature' => 'float',
        'humidity' => 'float',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * RELASI (Optional tapi Sangat Berguna):
     * Menghubungkan kembali data sensor ini ke pemiliknya (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
