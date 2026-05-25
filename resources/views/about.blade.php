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

    /* Kreatif & Interaktif style untuk Team Cards */
    .team-card {
        background: white;
        border: 1px solid #f1f5f9;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        position: relative;
        overflow: hidden;
    }

    .team-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #10b981, #3b82f6);
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }

    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.1);
        border-color: rgba(16, 185, 129, 0.3);
    }

    .team-card:hover::after {
        transform: scaleX(1);
    }

    .team-avatar {
        transition: all 0.4s ease;
    }

    .team-card:hover .team-avatar {
        transform: scale(1.05) rotate(2deg);
        box-shadow: 0 15px 30px -5px rgba(16, 185, 129, 0.2);
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
    <div class="grid lg:grid-cols-12 gap-8 mb-20">
        
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

    <!-- ==========================================================================
         SECTION: 8 PROFIL PEMBUAT / DEVELOPER TEAM (DENGAN FOTO)
         ========================================================================== -->
    <div class="mt-28">
        <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
            <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-4 py-1.5 rounded-full uppercase tracking-widest">
                Our Innovation Brains
            </span>
            <h3 class="text-4xl font-black text-slate-900 tracking-tight uppercase mt-4 mb-2">
                Tim Pengembang System
            </h3>
            <p class="text-slate-400 font-medium text-sm">
                Inovator dan teknisi di balik arsitektur perangkat keras IoT serta ekosistem digital AgroMonitor.
            </p>
        </div>

        @php
            // Data 8 personil lengkap dengan nama file foto masing-masing di folder public/images/team/
            $team_members = [
                ['name' => 'Vania Pamela Fri masfufah', 'nisn' => '0084196508', 'email' => 'vaniafrimasfufah@gmail.com', 'role' => 'Project Manager', 'bg_badge' => 'bg-emerald-100 text-emerald-700', 'photo' => 'images/team/vania.jpg'],
                ['name' => 'Indri Ratna Ferlina', 'nisn' => '0079933702', 'email' => 'ratnaindri3005@gmail.com', 'role' => 'Product Researcher', 'bg_badge' => 'bg-blue-100 text-blue-700', 'photo' => 'images/team/indri.jpg'],
                ['name' => 'Selvi Anggraeni', 'nisn' => '0081581935', 'email' => 'selvianggraeni700@gmail.com', 'role' => 'System Analyst', 'bg_badge' => 'bg-teal-100 text-teal-700', 'photo' => 'images/team/selvi.jpg'],
                ['name' => 'Rheza Alentta', 'nisn' => '0086713080', 'email' => 'rhezaalenta6@gmail.com', 'role' => 'IoT Hardware Engineer', 'bg_badge' => 'bg-purple-100 text-purple-700', 'photo' => 'images/team/rheza.jpg'],
                ['name' => 'Novia Anggi Natasya', 'nisn' => '0079878410', 'email' => 'novianggi07@icloud.com', 'role' => 'UI/UX Designer', 'bg_badge' => 'bg-rose-100 text-rose-700', 'photo' => 'images/team/novia.jpg'],
                ['name' => 'Zaky Virman Abi Fikhri', 'nisn' => '0077953415', 'email' => 'zakyvirmanabi32@gmail.com', 'role' => 'UI/UX Designer', 'bg_badge' => 'bg-cyan-100 text-cyan-700', 'photo' => 'images/team/zaky.jpg'],
                ['name' => 'Indah Firdlotul Azizah', 'nisn' => '0079593879', 'email' => 'indahazizah978@gmail.com', 'role' => 'IoT Hardware Engineer', 'bg_badge' => 'bg-indigo-100 text-indigo-700', 'photo' => 'images/team/indah.jpg'],
                ['name' => 'Laila Putri Rahmawati', 'nisn' => '0083645844', 'email' => 'lalarahmawati50@gmail.com', 'role' => 'Web Developer', 'bg_badge' => 'bg-indigo-100 text-indigo-700', 'photo' => 'images/team/laila.jpg'],
            ];
        @endphp

        <!-- Grid Container 8 Profile -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($team_members as $index => $member)
            <div class="team-card p-8 rounded-[2.5rem]" 
                 data-aos="fade-up" 
                 data-aos-delay="{{ ($index % 4) * 100 }}">
                
                <div class="relative flex justify-center mb-6">
                    <!-- Lingkaran Ornamen Belakang Foto -->
                    <div class="absolute inset-0 bg-slate-50 rounded-full scale-90 -z-10"></div>
                    
                    <!-- Avatar Foto Berbasis Gambar & Fallback Huruf Otomatis -->
                    <div class="team-avatar w-32 h-32 rounded-[2.5rem] bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-md border-4 border-white overflow-hidden select-none">
                        @if(file_exists(public_path($member['photo'])))
                            <img src="{{ asset($member['photo']) }}" alt="{{ $member['name'] }}" class="w-full h-full object-cover">
                        @else
                            <!-- Tampil otomatis jika file foto belum ada di folder komputer -->
                            <span class="text-4xl font-black">{{ substr($member['name'], 0, 1) }}</span>
                        @endif
                    </div>
                </div>

                <div class="text-center">
                    <!-- Badge Peran Anggota -->
                    <span class="inline-block px-3 py-1 text-[9px] font-extrabold uppercase rounded-lg tracking-wider mb-3 {{ $member['bg_badge'] }}">
                        {{ $member['role'] }}
                    </span>

                    <!-- Nama Lengkap -->
                    <h4 class="text-base font-black text-slate-800 tracking-tight mb-1 truncate px-1" title="{{ $member['name'] }}">
                        {{ $member['name'] }}
                    </h4>
                    
                    <!-- Detail Informasi Kolektif -->
                    <div class="space-y-3 mt-4 pt-4 border-t border-slate-50 text-left">
                        <div>
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Identification Number</p>
                            <p class="text-[11px] font-bold text-slate-600 font-mono bg-slate-50 px-2 py-1 rounded-md inline-block">
                                NISN: {{ $member['nisn'] }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Corporate Mail</p>
                            <a href="mailto:{{ $member['email'] }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition-colors flex items-center gap-1 truncate" title="{{ $member['email'] }}">
                                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $member['email'] }}
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
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