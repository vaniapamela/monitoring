@extends('layouts.app')

@section('content')
<!-- Library Animasi -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    .about-header {
        background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
        border-radius: 0 0 3rem 3rem;
    }

    .brand-card {
        background: white;
        border: 1px solid #f1f5f9;
        transition: all 0.4s ease;
    }

    .brand-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px -12px rgba(16, 185, 129, 0.15);
    }

    .feature-tag {
        background: #f0fdf4;
        color: #10b981;
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>

<!-- Header Section -->
<div class="about-header pt-36 pb-40 px-6">
    <div class="max-w-4xl mx-auto text-center" data-aos="zoom-out">
        <h2 class="text-[10px] font-black text-emerald-300 uppercase tracking-[0.4em] mb-4">Corporate Profile</h2>
        <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tighter mb-6 uppercase">
            Agro<span class="text-emerald-400">Monitor</span>
        </h1>
        <p class="text-emerald-100/70 text-base md:text-lg font-medium max-w-2xl mx-auto leading-relaxed">
            Membangun ekosistem pertanian cerdas melalui integrasi teknologi IoT untuk kedaulatan pangan masa depan.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 -mt-20 pb-24">
    <div class="grid lg:grid-cols-12 gap-8">
        
        <!-- Kolom Kiri: Profil Brand -->
        <div class="lg:col-span-4" data-aos="fade-up">
            <div class="brand-card p-10 rounded-[3rem] shadow-xl sticky top-28 overflow-hidden">
                <!-- Ornamen Brand -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full -mr-16 -mt-16"></div>
                
                <div class="relative z-10">
                    <img src="{{ asset('images/logo.jpeg') }}" 
                         alt="AgroMonitor Logo" 
                         class="w-24 h-24 rounded-[2rem] shadow-lg mb-8 object-cover border-4 border-white">
                    
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight uppercase mb-2">AgroMonitor</h3>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-8 italic text-emerald-600">Smart Agriculture Solution</p>
                    
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase mb-2">Bidang Fokus</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="feature-tag">IoT Sensing</span>
                                <span class="feature-tag">Smart Storage</span>
                                <span class="feature-tag">Big Data</span>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase mb-2">Lokasi Operasional</p>
                            <p class="text-sm font-bold text-slate-700">Malang, Jawa Timur, Indonesia</p>
                        </div>

                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-400 uppercase">Verification</span>
                            <div class="flex items-center gap-1 text-emerald-500 font-bold text-xs">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                                Official System
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Visi, Misi & Detail -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Cards Visi Misi -->
            <div class="grid md:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 font-black text-xl">V</div>
                    <h4 class="text-xl font-black text-slate-900 mb-4">Visi</h4>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Menjadi pionir dalam standardisasi teknologi penyimpanan hortikultura berbasis digital guna mendukung ketahanan pangan nasional.</p>
                </div>
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 font-black text-xl">M</div>
                    <h4 class="text-xl font-black text-slate-900 mb-4">Misi</h4>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Membangun infrastruktur monitoring yang presisi, mudah diakses, dan memberikan solusi nyata bagi efisiensi pengelolaan gudang pertanian.</p>
                </div>
            </div>

            <!-- About Company Content -->
            <div class="bg-white p-10 md:p-16 rounded-[3.5rem] border border-slate-50 shadow-sm" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-3xl font-black text-slate-900 mb-8 uppercase tracking-tighter">Tentang Platform</h3>
                <div class="space-y-6 text-slate-500 font-medium leading-loose text-base">
                    <p>
                        <strong class="text-slate-900 font-bold">AgroMonitor</strong> adalah platform manajemen gudang hortikultura yang lahir dari penggabungan antara teknik pertanian tradisional dan teknologi mutakhir. Kami percaya bahwa setiap komoditas memerlukan perlakuan khusus untuk mempertahankan kesegarannya.
                    </p>
                    <p>
                        Sistem kami menggunakan sensor real-time yang terhubung ke jaringan internet (IoT) untuk memantau suhu dan kelembapan secara konstan. Dengan algoritma yang disesuaikan untuk setiap jenis tanaman—mulai dari sayuran daun hingga buah tropis—kami memastikan parameter lingkungan selalu dalam kondisi optimal.
                    </p>
                </div>

                <div class="mt-12 flex flex-col md:flex-row gap-8 items-center bg-slate-50 p-8 rounded-3xl border border-slate-100">
                    <div class="text-center md:text-left flex-1">
                        <h5 class="text-slate-900 font-black uppercase text-sm mb-1 italic">High-Precision Hardware</h5>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">ESP8266 & DHT11 Integrated System</p>
                    </div>
                    <div class="h-px w-full md:w-px md:h-12 bg-slate-200"></div>
                    <div class="text-center md:text-left flex-1">
                        <h5 class="text-slate-900 font-black uppercase text-sm mb-1 italic">Real-time Analytics</h5>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Instant Data Stream to Dashboard</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({ 
            duration: 1000, 
            once: true,
            easing: 'ease-in-out'
        });
    });
</script>
@endsection