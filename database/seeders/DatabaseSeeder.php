<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Akun Admin Utama
        User::create([
            'name' => 'Admin AgroMonitor',
            'email' => 'admin@agromonitor.com',
            'password' => Hash::make('passwordadmin123'),
            'role' => 'admin',
        ]);

        // 2. Membuat Akun Penyewa Gudang (User 1)
        User::create([
            'name' => 'user penyewa',
            'email' => 'userpenyewa@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'tenant',
        ]);
    }
}
