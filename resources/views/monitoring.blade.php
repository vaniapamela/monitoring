@extends('layouts.app')

@section('content')
    {{-- <meta http-equiv="refresh" content="30"> --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        .header-emerald {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
            position: relative;
        }

        .font-digital {
            font-family: 'JetBrains Mono', monospace;
        }

        .stat-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            transform: translateY(-8px);
        }

        /* SOLUSI TOTAL KELURUSAN GARIS TEPI DAN DROPDOWN */
        select.super-clean {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            background-image: none !important;
            border: none !important;
            /* Menghilangkan garis tepi bawaan select */
            outline: none !important;
            /* Menghilangkan outline biru bawaan browser */
            box-shadow: none !important;
            /* Menghilangkan shadow bawaan select */
        }

        select.super-clean::-ms-expand {
            display: none !important;
        }

        /* Efek interaktif mewah untuk kotak filter saat di-klik/focus */
        .filter-box-focus:focus-within {
            border-color: #10b981 !important;
            /* Garis tepi berubah jadi emerald */
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1) !important;
            /* Efek glow halus */
        }
    </style>

    <div class="header-emerald pt-32 pb-44 px-6">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center" data-aos="fade-down">
                <div>
                    <h2 class="text-[10px] font-black text-emerald-300 uppercase tracking-[0.4em] mb-4">Pusat Kendali
                        Digital</h2>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tighter mb-6 uppercase leading-tight">
                        Monitoring <br><span class="text-emerald-400 font-black">Gudang Pintar</span>
                    </h1>
                    <p class="text-emerald-100/80 text-sm md:text-base max-w-lg leading-relaxed mb-8 font-medium">
                        Monitoring suhu dan kelembapan gudang secara realtime menggunakan sistem IoT berbasis Laravel dan
                        ESP8266.
                    </p>
                    {{-- Rubah --}}
                    <div class="flex flex-wrap gap-3 mb-8">
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-2xl">
                            <p class="text-[8px] text-emerald-300 font-black uppercase mb-0.5">Sensor</p>
                            <p class="text-white font-bold text-xs">DHT11 Ready</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-2xl">
                            <p class="text-[8px] text-emerald-300 font-black uppercase mb-0.5">Hardware</p>
                            <p class="text-white font-bold text-xs">ESP8266 Ready</p>
                        </div>
                    </div>
                    {{-- End Of Rubah --}}
                </div>

                <div class="bg-white/10 border border-white/20 p-8 rounded-[3rem] backdrop-blur-xl">
                    <div class="flex items-center justify-between mb-6">
                        <h4
                            class="text-white font-bold uppercase tracking-widest text-[10px] text-emerald-300 underline underline-offset-8 font-digital">
                            STATUS_KONEKSI</h4>
                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                    </div>
                    {{-- Rubah --}}
                    <div class="space-y-2">
                        <p class="text-3xl font-bold text-white uppercase tracking-tighter font-digital italic">
                            DEVICE_ONLINE</p>
                        <p class="text-emerald-200/60 text-[10px] font-bold uppercase tracking-wider">Data milik @
                            {{ Auth::user()->name }} berhasil sinkron</p>
                    </div>
                    {{-- End Of Rubah --}}
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 -mt-20 mb-12 relative z-30">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Rubah --}}
            <div
                class="stat-card bg-white p-10 rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-50 flex flex-col justify-between group">
                <p class="text-[10px] font-black text-slate-400 uppercase mb-4 tracking-[0.2em]">Suhu Udara</p>
                <div class="flex items-end gap-2">
                    <span
                        class="text-6xl font-bold text-slate-900 tracking-tighter font-digital italic">{{ $latest ? $latest->temperature : '--' }}°</span>
                    <span class="text-xs font-black text-rose-500 mb-2 uppercase tracking-widest">Celsius</span>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-300 uppercase">Scale: °C</span>
                    <span class="text-2xl">🌡️</span>
                </div>
            </div>
            {{-- End Of Rubah --}}
            {{-- Rubah --}}
            <div
                class="stat-card bg-white p-10 rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-50 flex flex-col justify-between group">
                <p class="text-[10px] font-black text-slate-400 uppercase mb-4 tracking-[0.2em]">Kelembapan</p>
                <div class="flex items-end gap-2">
                    <span
                        class="text-6xl font-bold text-slate-900 tracking-tighter font-digital italic">{{ $latest ? $latest->humidity : '--' }}%</span>
                    <span class="text-xs font-black text-blue-500 mb-2 uppercase tracking-widest">Humidity</span>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-300 uppercase">Scale: RH</span>
                    <span class="text-2xl">💧</span>
                </div>
            </div>
            {{-- End Of Rubah --}}
            {{-- Rubah --}}
            <div
                class="stat-card bg-white p-10 rounded-[3rem] shadow-2xl shadow-slate-200/50 border-2 border-dashed border-emerald-100 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-3xl mb-4">
                    @if ($warehouseStatus == 'AMAN')
                        ✅
                    @elseif($warehouseStatus == 'TIDAK AMAN')
                        ⚠️
                    @else
                        ⏳
                    @endif
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase mb-2 tracking-[0.2em]">Kondisi Gudang</p>
                <h4
                    class="text-2xl font-bold uppercase tracking-tighter font-digital italic @if ($warehouseStatus == 'AMAN') text-emerald-500 @elseif($warehouseStatus == 'TIDAK AMAN') text-rose-500 @else text-slate-300 @endif">
                    {{ $warehouseStatus }}
                </h4>
                <p class="text-[9px] font-bold text-slate-400 mt-3 uppercase tracking-widest">Smart Monitoring System</p>
            </div>
            {{-- End Of Rubah --}}
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Rubah --}}
            <div class="lg:col-span-2 bg-white rounded-[3.5rem] shadow-xl p-10 border border-slate-50">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h4 class="text-2xl font-bold text-slate-900 uppercase tracking-tighter italic font-digital">
                            Analysis_Chart</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Visualisasi Parameter
                            Grafik Batas Aman Terupdate</p>
                    </div>
                </div>
                <div class="h-[380px] w-full relative">
                    <canvas id="sensorChart"></canvas>
                </div>
            </div>
            {{-- End Of Rubah --}}
            {{-- Rubah --}}
            <div class="bg-white rounded-[3.5rem] shadow-xl p-10 border border-slate-50 flex flex-col">
                <h4 class="text-2xl font-bold text-slate-900 uppercase tracking-tighter mb-8 italic font-digital">
                    System_Logs</h4>
                <div class="space-y-4 overflow-y-auto max-h-[350px] pr-2">
                    @foreach ($history->take(5) as $item)
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-slate-700 text-sm font-digital">{{ $item->temperature }}°C /
                                        {{ $item->humidity }}%</p>
                                    <p class="text-[10px] text-slate-400 mt-1 font-digital">
                                        {{ $item->created_at->isoFormat('H:i:s / d M') }}</p>
                                </div>
                                @if ($item->temperature > 30 || $item->humidity > 85)
                                    <span
                                        class="bg-rose-100 text-rose-600 text-[10px] font-black px-3 py-1 rounded-full">ALERT</span>
                                @else
                                    <span
                                        class="bg-emerald-100 text-emerald-600 text-[10px] font-black px-3 py-1 rounded-full">SAFE</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- End Of Rubah --}}

        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pb-24">
        <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-slate-200/80 border border-slate-100 overflow-hidden"
            data-aos="fade-up">
            <div
                class="p-8 md:p-12 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 bg-gradient-to-b from-slate-50/50 to-white border-b border-slate-100">
                <div>
                    <h3 class="text-2xl font-black tracking-tighter text-slate-900 uppercase font-digital italic">
                        Log_Data_History</h3>
                    <p class="text-slate-400 text-xs mt-1 font-medium">Riwayat rekaman sensor dan status kendali penyimpanan
                        otomatis</p>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                    {{-- Rubah --}}
                    <form method="GET" action="/monitoring" id="filterForm"
                        class="filter-box-focus relative min-w-[210px] overflow-hidden rounded-2xl border border-slate-200 bg-white transition-all duration-300">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm pointer-events-none z-20">🔍</span>

                        <select name="status" onchange="document.getElementById('filterForm').submit()"
                            class="super-clean w-full pl-11 pr-12 py-3.5 bg-transparent text-slate-700 font-bold text-xs uppercase tracking-wider cursor-pointer relative z-10">
                            <option value="">📊 Semua Data</option>
                            <option value="aman" {{ $filter == 'aman' ? 'selected' : '' }}>🟢 Kondisi Aman</option>
                            <option value="tidak_aman" {{ $filter == 'tidak_aman' ? 'selected' : '' }}>🔴 Tidak Aman
                            </option>
                        </select>

                        <div
                            class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none flex items-center justify-center z-0">
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </form>
                    {{-- End Of Rubah --}}

                    <a href="{{ route('monitoring.pdf', ['status' => $filter]) }}"
                        class="bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs uppercase tracking-[0.15em] px-6 py-4 rounded-2xl flex items-center justify-center gap-3 shadow-lg shadow-emerald-900/20 hover:shadow-emerald-500/30 transform hover:-translate-y-1 transition-all duration-300 active:scale-95">
                        <span>📄</span> Unduh PDF Laporan
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100">
                            <th
                                class="p-6 text-center text-[10px] uppercase tracking-widest text-slate-400 font-black w-20">
                                No</th>
                            <th class="p-6 text-xs uppercase tracking-wider text-slate-500 font-bold">Suhu Udara</th>
                            <th class="p-6 text-xs uppercase tracking-wider text-slate-500 font-bold">Kelembapan</th>
                            <th class="p-6 text-xs uppercase tracking-wider text-slate-500 font-bold">Status Kipas</th>
                            <th class="p-6 text-xs uppercase tracking-wider text-slate-500 font-bold text-center">Status
                                Keamanan</th>
                            <th class="p-6 text-xs uppercase tracking-wider text-slate-500 font-bold">Waktu Sinkronisasi
                            </th>
                        </tr>
                    </thead>
                    {{-- Rubah --}}

                    <tbody class="divide-y divide-slate-50">
                        @forelse($history as $item)
                            @php
                                $isAman = $item->temperature <= 25 && $item->humidity <= 90;
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="p-6 text-center font-digital font-bold text-slate-400 text-xs">
                                    {{ $loop->iteration }}</td>
                                <td class="p-6">
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="text-sm font-black text-slate-800 font-digital">{{ $item->temperature }}</span>
                                        <span class="text-[10px] font-bold text-rose-500 uppercase">°C</span>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="text-sm font-black text-slate-800 font-digital">{{ $item->humidity }}</span>
                                        <span class="text-[10px] font-bold text-blue-500 uppercase">% RH</span>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <span
                                        class="px-3 py-1.5 rounded-xl text-[11px] font-bold font-digital {{ ($item->fan_status ?? 'OFF') == 'ON' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-slate-100 text-slate-500' }}">
                                        ⚙️ {{ $item->fan_status ?? 'OFF' }}
                                    </span>
                                </td>
                                <td class="p-6 text-center">
                                    @if ($isAman)
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100 px-4 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                            AMAN
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-700 border border-rose-100 px-4 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> TIDAK AMAN
                                        </span>
                                    @endif
                                </td>
                                <td class="p-6 text-slate-500 text-xs font-semibold font-digital">
                                    {{ $item->created_at->isoFormat('DD MMMM YYYY — HH:mm:ss') }} WIB
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-20 text-center">
                                    <div class="text-4xl mb-4">📭</div>
                                    <p class="text-slate-400 text-sm font-bold uppercase tracking-wide">Data Log Kosong</p>
                                    <p class="text-slate-300 text-xs mt-1">Belum ada aktivitas sensor terdeteksi untuk
                                        filter ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    {{-- End Of Rubah --}}

                </table>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        AOS.init({
            once: true
        });

        const labels = [
            @foreach ($chartData as $item)
                "{{ $item->created_at->isoFormat('H:i:s') }}",
            @endforeach
        ];
        const temperatureData = [
            @foreach ($chartData as $item)
                {{ $item->temperature }},
            @endforeach
        ];
        const humidityData = [
            @foreach ($chartData as $item)
                {{ $item->humidity }},
            @endforeach
        ];

        const ctx = document.getElementById('sensorChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Suhu (°C)',
                        data: temperatureData,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.04)',
                        borderWidth: 3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#ef4444',
                        tension: 0.35,
                        fill: true
                    },
                    {
                        label: 'Kelembapan (%)',
                        data: humidityData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.04)',
                        borderWidth: 3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#3b82f6',
                        tension: 0.35,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Plus Jakarta Sans',
                                weight: 'bold',
                                size: 11
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'JetBrains Mono',
                                size: 10
                            }
                        }
                    },
                    y: {
                        min: 0,
                        max: 100,
                        grid: {
                            color: 'rgba(226, 232, 240, 0.6)'
                        },
                        ticks: {
                            font: {
                                family: 'JetBrains Mono',
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
