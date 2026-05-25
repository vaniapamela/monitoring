<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'last_login_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime', // Agar mudah diolah dengan Carbon
            'password' => 'hashed',
        ];
    }

    /**
     * Hubungkan User ke Device
     */
    public function devices()
    {
        return $this->hasMany(DeviceModel::class);
    }

    /**
     * Hubungkan User ke Data Sensor (Melalui Device atau Langsung)
     * Asumsi: Jika sensor_data memiliki user_id
     */
    // Ganti fungsi sensorData di User.php menjadi ini:
    public function sensorData()
    {
        // User punya banyak SensorData melalui Device
        return $this->hasManyThrough(SensorData::class, Device::class);
    }

    /**
     * Mengambil data sensor terbaru saja untuk ditampilkan di dashboard
     */
    public function latestSensor()
    {
        return $this->hasOne(SensorData::class)->latestOfMany();
    }
}
