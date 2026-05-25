<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\SensorData;

#[Fillable(['name', 'email', 'password', 'role', 'token', 'last_login_at'])]
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
     * Hubungkan User ke Data Sensor (Melalui Device atau Langsung)
     * Asumsi: Jika sensor_data memiliki user_id
     */
    // Ganti fungsi sensorData di User.php menjadi ini:
    public function sensorData()
{
    return $this->hasMany(SensorData::class);
}

    /**
     * Mengambil data sensor terbaru saja untuk ditampilkan di dashboard
     */
    public function latestSensor()
    {
        return $this->hasOne(SensorData::class)->latestOfMany();
    }
}
