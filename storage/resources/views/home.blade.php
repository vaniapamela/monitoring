@extends('layouts.app')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
    
    .hero-container {
        background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.7)), 
                    url('https://images.unsplash.com/photo-1523741543316-beb7fc7023d8?q=60&w=1920');
        background-size: cover;
        background-position: center;
        min-height: 100vh; 
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-content { padding-top: 80px; }

    .btn-action { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.2);
    }

    /* Animasi untuk Status Offline */
    @keyframes pulse-red {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    .status-offline { animation: pulse-red 2s infinite; }

    .floating { animation: floating 3s ease-in-out infinite; }
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
</style>

<div class="relative overflow-hidden">
    
    <!-- HERO SECTION -->
    <section class="hero-container">
        <div class="relative z-10 text-center px-6 max-w-5xl hero-content" data-aos="fade-up" data-aos-duration="1000">

            <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-[1.1] mb-6 uppercase tracking-tighter">
                Gudang Pintar, <br> 
                <span class="text-emerald-400">Hasil Panen Maksimal.</span>
            </h1>

            <p class="text-base md:text-xl text-slate-200 max-w-3xl mx-auto mb-10 leading-relaxed font-medium">
                Pantau kondisi komoditas Anda secara real-time dengan teknologi 
                <span class="text-emerald-300 font-bold">IoT AgroMonitor</span>. Presisi tinggi untuk menjaga kualitas investasi pertanian Anda.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/monitoring"
                    class="w-full sm:w-auto btn-action bg-emerald-500 text-white px-10 py-5 rounded-2xl shadow-xl shadow-emerald-500/20 text-xs font-black uppercase tracking-[0.2em]">
                    Pantau Gudang Sekarang
                </a>

                <a href="/hortikultura"
                    class="w-full sm:w-auto btn-action border-2 border-white/30 text-white px-10 py-5 rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-white hover:text-slate-900">
                    Katalog Hortikultura
                </a>
            </div>
        </div>
    </section>

    <!-- CHALLENGE SECTION -->
    <section class="bg-white py-24 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-16 items-center">
            <div data-aos="fade-right">
                <h2 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.4em] mb-4">The Challenge</h2>
                <h3 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-8 tracking-tighter leading-tight">
                    Mengapa Monitoring <br> Digital Itu Wajib?
                </h3>
                <p class="text-slate-600 text-lg leading-relaxed mb-6 font-medium">
                    Lebih dari 30% hasil tani rusak karena kegagalan kontrol suhu. AgroMonitor meminimalisir risiko tersebut dengan sistem otomatisasi berbasis data.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start gap-4 p-5 rounded-3xl bg-slate-50 border border-slate-100 transition-all hover:bg-emerald-50">
                        <span class="text-2xl">✅</span>
                        <div>
                            <p class="font-bold text-slate-800">Otomatisasi Penuh</p>
                            <p class="text-sm text-slate-500">Sistem bekerja 24/7 tanpa perlu pengawasan manual terus-menerus.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="relative pt-10 floating" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1586771107445-d3ca888129ff?q=60&w=1200" 
                     class="rounded-[3rem] shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500">
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS SECTION -->
    <section class="py-24 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16" data-aos="zoom-in">
                <h2 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.4em] mb-4">Step by Step</h2>
                <h3 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight">Bagaimana Sistem Bekerja?</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 bg-white shadow-xl rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8">📡</div>
                    <h5 class="font-black text-slate-800 mb-3 uppercase tracking-tight">1. Sensor Membaca</h5>
                    <p class="text-slate-500 text-sm leading-relaxed">Sensor DHT11 mendeteksi suhu & kelembapan secara akurat di titik gudang.</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 bg-white shadow-xl rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8">☁️</div>
                    <h5 class="font-black text-slate-800 mb-3 uppercase tracking-tight">2. Kirim ke Cloud</h5>
                    <p class="text-slate-500 text-sm leading-relaxed">ESP8266 mengirim data melalui internet menuju server database AgroMonitor.</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-20 h-20 bg-white shadow-xl rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8">📱</div>
                    <h5 class="font-black text-slate-800 mb-3 uppercase tracking-tight">3. Pantau & Kontrol</h5>
                    <p class="text-slate-500 text-sm leading-relaxed">Anda menerima visualisasi data real-time dan notifikasi jika ada anomali.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION (Extended to 6 Features) -->
    <section class="bg-white py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20" data-aos="zoom-in">
                <h2 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.4em] mb-4">Our Technology</h2>
                <h3 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight">6 Fitur Unggulan AgroMonitor</h3>
                <div class="w-20 h-1.5 bg-emerald-500 mx-auto rounded-full mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- 1. Suhu -->
                <div class="bg-white p-10 rounded-[3rem] shadow-sm hover:shadow-xl transition-all border border-slate-100 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition-transform">🌡️</div>
                    <h4 class="text-xl font-black text-slate-800 mb-4 uppercase tracking-tighter">Presisi Suhu</h4>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Sensor yang dikalibrasi untuk memantau suhu ekstrem secara akurat.</p>
                </div>
                <!-- 2. Lembab -->
                <div class="bg-white p-10 rounded-[3rem] shadow-sm hover:shadow-xl transition-all border border-slate-100 group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-cyan-50 text-cyan-500 rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition-transform">💧</div>
                    <h4 class="text-xl font-black text-slate-800 mb-4 uppercase tracking-tighter">Kontrol Lembap</h4>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Menjaga stabilitas kadar air untuk mencegah pembusukan komoditas.</p>
                </div>
                <!-- 3. Grafik -->
                <div class="bg-white p-10 rounded-[3rem] shadow-sm hover:shadow-xl transition-all border border-slate-100 group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition-transform">📊</div>
                    <h4 class="text-xl font-black text-slate-800 mb-4 uppercase tracking-tighter">Analisis Grafik</h4>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Visualisasi tren data harian yang interaktif untuk keputusan cepat.</p>
                </div>
                <!-- 4. Real-time -->
                <div class="bg-white p-10 rounded-[3rem] shadow-sm hover:shadow-xl transition-all border border-slate-100 group" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition-transform">📡</div>
                    <h4 class="text-xl font-black text-slate-800 mb-4 uppercase tracking-tighter">Akses Real-Time</h4>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Pantau kondisi gudang dari mana saja melalui smartphone atau laptop.</p>
                </div>
                <!-- 5. Notifikasi -->
                <div class="bg-white p-10 rounded-[3rem] shadow-sm hover:shadow-xl transition-all border border-slate-100 group" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition-transform">⚡</div>
                    <h4 class="text-xl font-black text-slate-800 mb-4 uppercase tracking-tighter">Notifikasi Instan</h4>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Peringatan otomatis jika kondisi lingkungan melewati ambang batas aman.</p>
                </div>
                <!-- 6. Log -->
                <div class="bg-white p-10 rounded-[3rem] shadow-sm hover:shadow-xl transition-all border border-slate-100 group" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition-transform">📁</div>
                    <h4 class="text-xl font-black text-slate-800 mb-4 uppercase tracking-tighter">Log Transmisi</h4>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Rekam jejak data lengkap untuk audit kualitas dan sejarah iklim gudang.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CALL TO ACTION -->
    <section class="bg-emerald-950 py-24 px-6 relative overflow-hidden text-center border-t border-emerald-900">
        <div class="relative z-10 max-w-4xl mx-auto" data-aos="zoom-in-up">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-8 uppercase leading-tight tracking-tighter">
                Siap Menjadi Bagian dari <br> <span class="text-emerald-400">Revolusi Pertanian Digital?</span>
            </h2>
            <a href="/contact" class="inline-block bg-white text-emerald-900 px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-emerald-400 hover:text-white transition-all shadow-xl shadow-emerald-950/20">
                Hubungi Tim Kami
            </a>
        </div>
        <div class="absolute top-0 right-0 w-80 h-80 bg-emerald-500/20 blur-[120px]"></div>
    </section>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: false, mirror: true });
</script>
@endsection