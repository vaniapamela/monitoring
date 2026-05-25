<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>AgroMonitor | Masuk Sistem</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            .auth-bg {
                background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.8)), 
                            url('https://images.unsplash.com/photo-1523741543316-beb7fc7023d8?q=60&w=1920');
                background-size: cover;
                background-position: center;
            }
        </style>
    </head>
    <body class="text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 auth-bg px-4">
            
            <div class="absolute top-6 left-6">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-300 hover:text-white transition-colors no-underline bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/10">
                    ← Kembali ke Home
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 bg-white/90 backdrop-blur-xl shadow-2xl border border-white/20 rounded-[2.5rem] p-8 sm:p-10 transition-all">
                
                <div class="flex flex-col items-center mb-8">
                    <img 
                        src="{{ asset('images/logo.jpeg') }}"
                        class="w-16 h-16 rounded-2xl shadow-md object-cover mb-4 border border-emerald-500/20"
                        alt="AgroMonitor Logo"
                    >
                    <h2 class="text-2xl font-extrabold tracking-tighter text-slate-950 uppercase">
                        Agro<span class="text-emerald-600">Monitor</span>
                    </h2>
                    <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">Smart Warehouse Gateway</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <div class="text-sm">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <x-input-label for="email" value="Email" class="text-xs font-bold text-slate-700 uppercase tracking-wider" />
                            <x-text-input id="email" class="block mt-1 w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <div class="flex justify-between items-center">
                                <x-input-label for="password" value="Password" class="text-xs font-bold text-slate-700 uppercase tracking-wider" />
                                @if (Route::has('password.request'))
                                    <a class="text-xs font-bold text-slate-400 hover:text-emerald-600 transition-colors no-underline uppercase tracking-wider" href="{{ route('password.request') }}">
                                        Lupa?
                                    </a>
                                @endif
                            </div>
                            
                            <div class="relative mt-1">
                                <x-text-input id="password" class="block w-full pr-10 border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm"
                                                type="password"
                                                name="password"
                                                required autocomplete="current-password" />
                                
                                <button type="button" onclick="togglePassword('password', 'eye-icon-login')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-emerald-500 border-none bg-transparent cursor-pointer">
                                    <svg id="eye-icon-login" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded-md border-slate-200 text-emerald-500 shadow-sm focus:ring-emerald-500" name="remember">
                                <span class="ms-2 text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('Ingat Saya') }}</span>
                            </label>
                        </div>

                        <div class="flex flex-col gap-4 items-center justify-end mt-8">
                            <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-black uppercase tracking-widest py-3 px-4 rounded-xl shadow-lg shadow-emerald-500/20 transition-all text-xs border-none cursor-pointer text-center">
                                Masuk ke Akun
                            </button>

                            <a class="text-xs font-bold text-slate-400 hover:text-emerald-600 transition-colors no-underline uppercase tracking-wider" href="{{ route('register') }}">
                                {{ __('Belum punya akun? Daftar di sini') }}
                            </a>
                        </div>
                    </form>
                </div>
                
            </div>

            <div class="mt-8 text-center">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest">&copy; 2026 AgroMonitor IoT Team</p>
            </div>

        </div>

        <script>
            function togglePassword(inputId, iconId) {
                const passwordInput = document.getElementById(inputId);
                const eyeIcon = document.getElementById(iconId);
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.69 9.69a3 3 0 004.243 4.243m1.83-1.83l3.54 3.54M4.929 4.929l14.142 14.142M12 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.4M9.69 9.69L4.93 4.93m4.76 4.76a3 3 0 014.243 0m0 0l4.76 4.76" />
                    `;
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            }
        </script>
    </body>
</html>