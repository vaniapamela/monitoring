@extends('layouts.app')

@section('content')

<!-- Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&family=JetBrains+Mono:ital,wght=0,700;1,700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
        overflow-x: hidden;
    }

    .header-horti {
        background:
            linear-gradient(135deg, rgba(6, 78, 59, 0.95), rgba(6, 95, 70, 0.85)),
            url('https://images.unsplash.com/photo-1592419044706-39796d40f98c?q=80&w=1920');

        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        border-radius: 0 0 4rem 4rem;
    }

    .section-title {
        position: relative;
        padding-left: 1.5rem;
        border-left: 5px solid #10b981;
    }

    .horti-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        position: relative;
        overflow: hidden;
    }

    .horti-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #10b981, #34d399);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .horti-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 30px 60px -12px rgba(15, 23, 42, 0.12);
        border-color: #10b981;
    }

    .horti-card:hover::before {
        opacity: 1;
    }

    .icon-box {
        width: 70px;
        height: 70px;
        background: #f0fdf4;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        transition: all 0.4s ease;
    }

    .horti-card:hover .icon-box {
        background: #064e3b;
        transform: rotate(-10deg) scale(1.1);
    }

    .font-digital {
        font-family: 'JetBrains Mono', monospace;
    }

    .badge-label {
        font-size: 8px;
        font-weight: 800;
        letter-spacing: 1px;
        padding: 4px 10px;
        border-radius: 8px;
        text-transform: uppercase;
    }

    /* Style tambahan untuk tombol filter aktif */
    .filter-btn.active {
        background-color: #10b981 !important;
        color: white !important;
        border-color: #10b981 !important;
        box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
    }
</style>

<!-- HERO -->
<div class="header-horti pt-36 pb-56 px-6 relative shadow-2xl">
    <div class="max-w-7xl mx-auto text-center relative z-10"
         data-aos="zoom-in"
         data-aos-duration="1000">

        <div class="inline-block px-4 py-1.5 bg-emerald-500/20 backdrop-blur-md border border-emerald-400/30 rounded-full mb-6">
            <span class="text-[10px] font-black text-emerald-200 uppercase tracking-[0.4em]">
                Horticultural Database v2.5
            </span>
        </div>

        <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tighter mb-6 leading-tight">
            Standarisasi
            <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">
                Logistik Pangan
            </span>
        </h1>

        <p class="text-emerald-50/70 max-w-2xl mx-auto text-base md:text-lg font-medium leading-relaxed italic">
            "Presisi suhu dan kelembapan membantu menjaga kualitas hasil pertanian
            tetap segar dari gudang hingga ke tangan konsumen."
        </p>
    </div>
</div>

<!-- CONTENT -->
<div class="max-w-7xl mx-auto px-6 -mt-32 pb-24 relative z-20">

    @php
        // Data di-satukan agar JavaScript bisa melakukan filter dan pengurutan (Sorting) global secara dinamis
        $all_items = [
            ['name' => 'Bawang Merah', 'icon' => '🧅', 'temp' => '25-30', 'sort_temp' => 25, 'hum' => '65-70', 'type' => 'sayur'],
            ['name' => 'Cabai Merah', 'icon' => '🌶️', 'temp' => '0-5', 'sort_temp' => 0, 'hum' => '90-95', 'type' => 'sayur'],
            ['name' => 'Kentang', 'icon' => '🥔', 'temp' => '10-15', 'sort_temp' => 10, 'hum' => '85-90', 'type' => 'sayur'],
            ['name' => 'Tomat', 'icon' => '🍅', 'temp' => '13-15', 'sort_temp' => 13, 'hum' => '85-90', 'type' => 'sayur'],
            ['name' => 'Wortel', 'icon' => '🥕', 'temp' => '0', 'sort_temp' => 0, 'hum' => '95-100', 'type' => 'sayur'],
            ['name' => 'Kubis', 'icon' => '🥬', 'temp' => '0-1', 'sort_temp' => 0, 'hum' => '95-100', 'type' => 'sayur'],
            ['name' => 'Bawang Putih', 'icon' => '🧄', 'temp' => '0', 'sort_temp' => 0, 'hum' => '65-70', 'type' => 'sayur'],
            ['name' => 'Brokoli', 'icon' => '🥦', 'temp' => '0', 'sort_temp' => 0, 'hum' => '95-100', 'type' => 'sayur'],
            ['name' => 'Jeruk', 'icon' => '🍊', 'temp' => '5-9', 'sort_temp' => 5, 'hum' => '85-90', 'type' => 'buah'],
            ['name' => 'Apel', 'icon' => '🍎', 'temp' => '0-4', 'sort_temp' => 0, 'hum' => '90-95', 'type' => 'buah'],
            ['name' => 'Mangga', 'icon' => '🥭', 'temp' => '13', 'sort_temp' => 13, 'hum' => '85-90', 'type' => 'buah'],
            ['name' => 'Pisang', 'icon' => '🍌', 'temp' => '13-15', 'sort_temp' => 13, 'hum' => '85-90', 'type' => 'buah'],
            ['name' => 'Alpukat', 'icon' => '🥑', 'temp' => '7-12', 'sort_temp' => 7, 'hum' => '85-90', 'type' => 'buah'],
            ['name' => 'Anggur', 'icon' => '🍇', 'temp' => '0-1', 'sort_temp' => 0, 'hum' => '90-95', 'type' => 'buah'],
            ['name' => 'Nanas', 'icon' => '🍍', 'temp' => '10-13', 'sort_temp' => 10, 'hum' => '85-90', 'type' => 'buah'],
            ['name' => 'Semangka', 'icon' => '🍉', 'temp' => '10-12', 'sort_temp' => 10, 'hum' => '85-90', 'type' => 'buah'],
        ];
    @endphp

    <div class="mb-24">
        <!-- Bagian Filter & Judul Dinamis -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12" data-aos="fade-right">
            <div class="section-title">
                <h3 id="page-title" class="text-3xl font-black text-slate-900 tracking-tight transition-all duration-300">
                    Semua Komoditas (Terhangat → Terdingin)
                </h3>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">
                    Sorted by Highest Temperature Threshold
                </p>
            </div>

            <!-- Tombol Navigasi Filter -->
            <div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-md border border-slate-100 self-start md:self-auto">
                <button onclick="filterKategori('all')" class="filter-btn active px-5 py-2.5 rounded-xl font-bold text-sm text-slate-600 hover:bg-slate-50 transition-all duration-300">
                    🌐 Semua
                </button>
                <button onclick="filterKategori('sayur')" class="filter-btn px-5 py-2.5 rounded-xl font-bold text-sm text-slate-600 hover:bg-slate-50 transition-all duration-300">
                    🥬 Sayuran
                </button>
                <button onclick="filterKategori('buah')" class="filter-btn px-5 py-2.5 rounded-xl font-bold text-sm text-slate-600 hover:bg-slate-50 transition-all duration-300">
                    🍎 Buah-buahan
                </button>
            </div>
        </div>

        <!-- Grid Container Utama -->
        <div id="horti-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($all_items as $index => $item)
            <!-- Atribut data-type dan data-temp ditambahkan di bawah ini untuk kebutuhan JS -->
            <div class="horti-card p-10 rounded-[3rem] shadow-xl shadow-slate-200/40 block"
                 data-type="{{ $item['type'] }}"
                 data-temp="{{ $item['sort_temp'] }}"
                 data-aos="fade-up">

                <div class="icon-box mb-8 shadow-inner relative">
                    {{ $item['icon'] }}
                    <!-- Badge info kecil tipe komoditas -->
                    <span class="absolute -bottom-1 -right-1 text-[10px] px-2 py-0.5 rounded-md font-bold {{ $item['type'] == 'sayur' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $item['type'] }}
                    </span>
                </div>

                <h4 class="text-xl font-black text-slate-800 mb-6 tracking-tighter">
                    {{ $item['name'] }}
                </h4>

                <div class="space-y-5">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">
                            Temperature
                        </p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-bold font-digital text-rose-600 italic leading-none">
                                {{ $item['temp'] }}
                            </span>
                            <span class="text-xs font-bold text-rose-400 uppercase">
                                °C
                            </span>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">
                            Humidity
                        </p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-bold font-digital text-cyan-600 italic leading-none">
                                {{ $item['hum'] }}
                            </span>
                            <span class="text-xs font-bold text-cyan-400 uppercase">
                                % RH
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- PENJELASAN -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-20" data-aos="fade-up">
        <!-- LEFT -->
        <div class="lg:col-span-5 p-12 bg-white rounded-[4rem] shadow-2xl border border-emerald-50 flex flex-col justify-center">
            <div class="w-24 h-1 bg-emerald-500 rounded-full mb-8"></div>
            <h4 class="text-3xl font-black text-slate-900 leading-tight mb-6 uppercase tracking-tighter">
                Pentinya Stabilitas Suhu & Kelembapan
            </h4>
            <p class="text-slate-500 leading-relaxed font-medium mb-6">
                Suhu dan kelembapan yang tidak stabil dapat menyebabkan hasil pertanian
                lebih cepat membusuk, berjamur, serta kehilangan kualitas penyimpanan.
                Sistem monitoring berbasis IoT membantu menjaga kondisi gudang tetap
                optimal melalui pemantauan realtime dan pengendalian otomatis.
            </p>
            <div class="flex gap-4 flex-wrap">
                <span class="badge-label bg-emerald-100 text-emerald-600">Real-Time Monitoring</span>
                <span class="badge-label bg-cyan-100 text-cyan-600">Smart Storage</span>
                <span class="badge-label bg-orange-100 text-orange-600">Quality Control</span>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="lg:col-span-7 bg-emerald-900 rounded-[4rem] p-12 text-white relative overflow-hidden">
            <h4 class="text-2xl font-black uppercase mb-10 italic flex items-center gap-3">
                <span class="flex h-3 w-3 rounded-full bg-emerald-400 animate-ping"></span>
                SOP Pengendalian IoT
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                @foreach([
                    ['SENSING', 'DHT11 mendeteksi perubahan suhu dan kelembapan secara realtime.', 'bg-emerald-800'],
                    ['ANALYSIS', 'Sistem memvalidasi data berdasarkan ambang batas penyimpanan.', 'bg-emerald-700'],
                    ['ACTION', 'Relay mengaktifkan kipas atau humidifier secara otomatis.', 'bg-emerald-600']
                ] as $step)
                <div class="{{ $step[2] }} p-6 rounded-3xl border border-white/10 hover:scale-105 transition-transform cursor-default">
                    <h5 class="font-black text-xs uppercase tracking-widest mb-3 text-emerald-300">
                        {{ $step[0] }}
                    </h5>
                    <p class="text-sm font-medium text-emerald-50/80 leading-snug">
                        {{ $step[1] }}
                    </p>
                </div>
                @endforeach
            </div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-emerald-400/20 rounded-full blur-[100px]"></div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Jalankan Inisialisasi Sorting Terhangat -> Terdingin saat halaman baru dimuat
        sortCardsDescending();

        // 2. Jalankan AOS (Animation)
        AOS.init({
            duration: 1000,
            once: false,
            easing: 'ease-out-back',
            offset: 50
        });
    });

    // Fungsi Utama untuk Mengurutkan Data berdasarkan Suhu Terhangat (Besar ke Kecil)
    function sortCardsDescending() {
        const grid = document.getElementById('horti-grid');
        const cards = Array.from(grid.getElementsByClassName('horti-card'));

        cards.sort((a, b) => {
            let tempA = parseInt(a.getAttribute('data-temp'));
            let tempB = parseInt(b.getAttribute('data-temp'));
            return tempB - tempA; // Mengurutkan besar ke kecil (descending)
        });

        // Masukkan kembali card yang sudah berurutan ke dalam grid HTML
        cards.forEach(card => grid.appendChild(card));
    }

    // Fungsi Utama untuk Filter Kategori (Semua / Sayur / Buah)
    function filterKategori(kategori) {
        const cards = document.querySelectorAll('.horti-card');
        const titleElement = document.getElementById('page-title');
        
        // Ubah Judul halaman sesuai filter yang aktif
        if (kategori === 'all') {
            titleElement.innerText = "Semua Komoditas (Terhangat → Terdingin)";
        } else if (kategori === 'sayur') {
            titleElement.innerText = "Kategori Sayuran (Terhangat → Terdingin)";
        } else if (kategori === 'buah') {
            titleElement.innerText = "Kategori Buah-buahan (Terhangat → Terdingin)";
        }

        // Jalankan logic show/hide card dengan transisi lembut
        cards.forEach(card => {
            const type = card.getAttribute('data-type');
            if (kategori === 'all' || type === kategori) {
                card.style.display = 'block';
                card.setAttribute('data-aos', 'fade-up'); // Pasang kembali animasi AOS
            } else {
                card.style.display = 'none';
            }
        });

        // Refresh AOS agar animasi efek muncul kembali bekerja normal pada card yang di-filter
        AOS.refresh();

        // Ubah style state active pada tombol filter yang sedang diklik
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');
    }
</script>

@endsection