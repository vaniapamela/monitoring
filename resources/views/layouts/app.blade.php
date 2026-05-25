<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>AgroMonitor | Smart Warehouse IoT</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpeg') }}">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    {{-- Wadah untuk menyuntikkan aset CSS/Script spesifik dari halaman anak seperti monitoring --}}
    @stack('styles')
</head>

<body class="bg-[#f8fafc] text-slate-700" x-data="{ mobileMenu: false }">

    <!-- NAVBAR UTAMA -->
    <nav class="bg-white/80 backdrop-blur-lg border-b border-slate-100 fixed w-full top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img 
                    src="{{ asset('images/logo.jpeg') }}"
                    class="w-10 h-10 rounded-xl shadow-inner object-cover"
                    alt="AgroMonitor Logo"
                >
                <h1 class="text-xl font-extrabold tracking-tighter text-slate-900 uppercase">
                    Agro<span class="text-emerald-500">Monitor</span>
                </h1>
            </div>

            <!-- Navigasi Desktop -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-emerald-600 transition-colors no-underline">Beranda</a>
                <a href="{{ url('/about') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-emerald-600 transition-colors no-underline">Tentang</a>
                
                @auth
                    @if(Auth::user()?->role !== 'admin')
                        <a href="{{ url('/monitoring') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-emerald-600 transition-colors no-underline">Monitoring</a>
                    @endif
                    
                    @if(Auth::user()?->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="text-xs font-black uppercase tracking-widest text-purple-600 hover:text-purple-800 transition-colors no-underline">👑 Kelola User</a>
                    @endif
                @endauth
                
                <a href="{{ url('/hortikultura') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-emerald-600 transition-colors no-underline">Hortikultura</a>
                <a href="{{ url('/contact') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-emerald-600 transition-colors no-underline">Kontak</a>
            </div>

            <!-- Menu Pengguna / Autentikasi -->
            <div class="flex items-center gap-4">
                <div class="hidden md:block">
                    @auth
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-slate-700 hover:text-emerald-600 focus:outline-none transition-colors border-none bg-transparent cursor-pointer">
                                <div>{{ Auth::user()?->name ?? 'User' }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>

                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg py-2 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 no-underline">
                                    Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 border-none bg-transparent cursor-pointer">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="space-x-3">
                            <a href="{{ route('login') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-emerald-600 transition-colors no-underline">
                                Masuk
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Tombol Hamburger Mobile -->
                <button @click="mobileMenu = true" class="block md:hidden p-2 rounded-xl bg-slate-50 text-slate-700 border border-slate-100 hover:bg-slate-100 transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

        </div>
    </nav>

    <!-- NAVIGASI MOBILE (SIDERBAR & OVERLAY) -->
    <div x-show="mobileMenu" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenu = false"
         class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-50 md:hidden"
         style="display: none;"></div>

    <div class="fixed top-0 right-0 bottom-0 w-72 bg-white z-50 shadow-2xl p-6 flex flex-col justify-between md:hidden transform transition duration-300 ease-in-out"
         x-show="mobileMenu"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         style="display: none;">
        
        <div>
            <div class="flex items-center justify-between pb-6 border-b border-slate-100 mb-8">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="w-8 h-8 rounded-lg object-cover">
                    <span class="font-extrabold text-slate-800 text-sm uppercase">Agro<span class="text-emerald-500">Monitor</span></span>
                </div>
                <button @click="mobileMenu = false" class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition-all border-none cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex flex-col gap-2.5">
                <a href="{{ url('/') }}" class="px-4 py-3 text-xs font-black uppercase tracking-widest text-slate-600 bg-slate-50 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-all no-underline">Beranda</a>
                <a href="{{ url('/about') }}" class="px-4 py-3 text-xs font-black uppercase tracking-widest text-slate-600 bg-slate-50 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-all no-underline">Tentang</a>
                
                @auth
                    @if(Auth::user()?->role !== 'admin')
                        <a href="{{ url('/monitoring') }}" class="px-4 py-3 text-xs font-black uppercase tracking-widest text-slate-600 bg-slate-50 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-all no-underline">Monitoring</a>
                    @endif
                    
                    <a href="{{ route('profile.edit') }}" class="px-4 py-3 text-xs font-black uppercase tracking-widest text-slate-600 bg-slate-50 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-all no-underline">Profile</a>
                    
                    @if(Auth::user()?->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-3 text-xs font-black uppercase tracking-widest text-purple-600 bg-purple-50 rounded-xl hover:bg-purple-100 transition-all no-underline">👑 Kelola User</a>
                    @endif
                @endauth
                
                {{-- Koreksi typo pemanggilan route hortikultura di bawah ini --}}
                <a href="{{ url('/hortikultura') }}" class="px-4 py-3 text-xs font-black uppercase tracking-widest text-slate-600 bg-slate-50 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-all no-underline">Hortikultura</a>
                <a href="{{ url('/contact') }}" class="px-4 py-3 text-xs font-black uppercase tracking-widest text-slate-600 bg-slate-50 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-all no-underline">Kontak</a>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center py-3.5 bg-rose-500 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-rose-600 transition-all shadow-md shadow-rose-500/10 border-none cursor-pointer">
                        Log Out
                    </button>
                </form>
            @else
                <div class="flex flex-col gap-3">
                    <a href="{{ route('login') }}" class="w-full text-center py-3 border border-slate-200 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all no-underline">
                        Masuk
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- MAIN Halaman Klien -->
    <main class="pt-24 min-h-screen">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-100 py-16">
        <div class="container mx-auto px-6 grid md:grid-cols-4 gap-12">
            
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('images/logo.jpeg') }}" class="w-8 h-8 rounded-lg" alt="AgroMonitor Logo">
                    <span class="text-lg font-black uppercase tracking-tighter">AgroMonitor</span>
                </div>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Solusi monitoring cerdas berbasis IoT untuk menjaga stabilitas suhu 
                    dan kelembapan gudang pertanian secara realtime, efisien, dan modern.
                </p>
            </div>

            <div>
                <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-6">Navigasi</h4>
                <ul class="space-y-4 text-sm font-bold text-slate-600 list-none p-0">
                    <li><a href="/" class="hover:text-emerald-500 transition no-underline">Beranda</a></li>
                    <li><a href="/about" class="hover:text-emerald-500 transition no-underline">Tentang</a></li>
                    @auth
                        @if(Auth::user()?->role !== 'admin')
                            <li><a href="/monitoring" class="hover:text-emerald-500 transition no-underline">Monitoring</a></li>
                        @endif
                    @endauth
                    <li><a href="/hortikultura" class="hover:text-emerald-500 transition no-underline">Hortikultura</a></li>
                    <li><a href="/contact" class="hover:text-emerald-500 transition no-underline">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-6">Hubungi Kami</h4>
                <ul class="space-y-4 text-sm font-bold text-slate-600 list-none p-0">
                    <li class="flex flex-col gap-0.5">
                        <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider">Instagram</span>
                        <a href="https://instagram.com/agromonitor.official" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-500 transition no-underline text-slate-600">agromonitor.official</a>
                    </li>
                    <li class="flex flex-col gap-0.5">
                        <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider">YouTube</span>
                        <a href="https://youtube.com/@agromonitorofficial" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-500 transition no-underline text-slate-600">agromonitorofficial</a>
                    </li>
                    <li class="flex flex-col gap-0.5">
                        <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider">TikTok</span>
                        <a href="https://tiktok.com/@agromonitoroffcial" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-500 transition no-underline text-slate-600">agromonitoroffcial</a>
                    </li>
                    <li class="flex flex-col gap-0.5">
                        <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider">Email Resmi</span>
                        <a href="mailto:agrocorporateo@gmail.com" class="hover:text-emerald-500 transition no-underline text-slate-600">agrocorporateo@gmail.com</a>
                    </li>
                </ul>
            </div>

            <div class="bg-slate-50 p-6 rounded-[2rem] flex flex-col justify-between min-h-[230px]">
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-2">System Status</h4>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-xs font-black text-slate-900 uppercase">All Systems Operational</span>
                    </div>
                </div>
                
                <div class="mt-6 md:mt-0 flex flex-col gap-4">
                    <div>
                        <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider block mb-0.5">Lokasi Utama</span>
                        <p class="text-xs font-bold text-slate-600 m-0">Malang, Jawa Timur</p>
                    </div>
                    
                    <div class="pt-3 border-t border-slate-200/80 flex flex-col gap-1">
                        <p class="text-[10px] font-black text-slate-400 m-0 uppercase tracking-tight">
                            &copy; 2026 AgroMonitor.<br>All Rights Reserved.
                        </p>
                        <p class="text-[9px] font-black text-emerald-500/80 m-0 uppercase tracking-widest">
                            Smart Agri IoT
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>