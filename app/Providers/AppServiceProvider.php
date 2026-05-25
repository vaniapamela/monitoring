<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Setiap kali user berhasil login, jalankan perintah ini
        Event::listen(function (Login $event) {
            $event->user->update([
                'last_login_at' => now(), // Mencatat waktu sekarang
                'login_count'   => $event->user->login_count + 1,
            ]);
        });
    }
}