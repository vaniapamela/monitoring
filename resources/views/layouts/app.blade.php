<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>AgroMonitor | Smart Warehouse IoT</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpeg') }}">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-700">

    <!-- NAVBAR -->
    <nav class="bg-white/80 backdrop-blur-lg border-b border-slate-100 fixed w-full top-0 z-50">
        
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">

            <!-- LOGO -->
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

            <!-- MENU -->
            <div class="hidden md:flex items-center gap-8">

                @foreach([
                    'Home' => '/',
                    'About' => '/about',
                    'Monitoring' => '/monitoring',
                    'Hortikultura' => '/hortikultura',
                    'Contact' => '/contact'
                ] as $label => $url)

                <a 
                    href="{{ $url }}"
                    class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-emerald-600 transition-colors"
                >
                    {{ $label }}
                </a>

                @endforeach

            </div>

        </div>

    </nav>

    <!-- CONTENT -->
    <main class="pt-18">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-100 py-16">

        <div class="container mx-auto px-6 grid md:grid-cols-4 gap-12">

            <!-- BRAND -->
            <div>

                <div class="flex items-center gap-3 mb-6">

                    <img 
                        src="{{ asset('images/logo.jpeg') }}"
                        class="w-8 h-8 rounded-lg"
                        alt="AgroMonitor Logo"
                    >

                    <span class="text-lg font-black uppercase tracking-tighter">
                        AgroMonitor
                    </span>

                </div>

                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Solusi monitoring cerdas berbasis IoT untuk menjaga stabilitas suhu 
                    dan kelembapan gudang pertanian secara realtime, efisien, dan modern.
                </p>

            </div>

            <!-- NAVIGATION -->
            <div>

                <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-6">
                    Navigasi
                </h4>

                <ul class="space-y-4 text-sm font-bold text-slate-600">

                    <li>
                        <a href="/" class="hover:text-emerald-500 transition">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="/about" class="hover:text-emerald-500 transition">
                            About
                        </a>
                    </li>

                    <li>
                        <a href="/monitoring" class="hover:text-emerald-500 transition">
                            Monitoring
                        </a>
                    </li>

                    <li>
                        <a href="/hortikultura" class="hover:text-emerald-500 transition">
                            Hortikultura
                        </a>
                    </li>

                    <li>
                        <a href="/contact" class="hover:text-emerald-500 transition">
                            Contact
                        </a>
                    </li>

                </ul>

            </div>

            <!-- CONTACT -->
            <div>

                <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-6">
                    Contact
                </h4>

                <ul class="space-y-4 text-sm font-bold text-slate-600">
                    <li>agromonitor@gmail.com</li>
                    <li>Malang, East Java</li>
                </ul>

            </div>

            <!-- SYSTEM STATUS -->
            <div class="bg-slate-50 p-6 rounded-[2rem]">

                <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-2">
                    System Status
                </h4>

                <div class="flex items-center gap-2">

                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>

                    <span class="text-xs font-black text-slate-900 uppercase">
                        All Systems Operational
                    </span>

                </div>

            </div>

        </div>

    </footer>

</body>
</html>