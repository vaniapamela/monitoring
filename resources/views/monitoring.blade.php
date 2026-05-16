@extends('layouts.app')

@section('content')

<meta http-equiv="refresh" content="30">

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">

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

    @keyframes pulse-red {

        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
        }
    }

    .status-pulse-red {
        animation: pulse-red 2s infinite;
    }

    .stat-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        transform: translateY(-8px);
    }

</style>

<!-- HEADER -->

<div class="header-emerald pt-32 pb-44 px-6">

    <div class="max-w-7xl mx-auto relative z-10">

        <div class="grid lg:grid-cols-2 gap-12 items-center" data-aos="fade-down">

            <div>

                <h2 class="text-[10px] font-black text-emerald-300 uppercase tracking-[0.4em] mb-4">
                    Pusat Kendali Digital
                </h2>

                <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tighter mb-6 uppercase leading-tight">
                    Monitoring <br>
                    <span class="text-emerald-400 font-black">
                        Gudang Pintar
                    </span>
                </h1>

                <p class="text-emerald-100/80 text-sm md:text-base max-w-lg leading-relaxed mb-8 font-medium">
                    Monitoring suhu dan kelembapan gudang secara realtime menggunakan sistem IoT berbasis Laravel dan ESP8266.
                </p>

                <div class="flex flex-wrap gap-3 mb-8">

                    <div class="bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-2xl">

                        <p class="text-[8px] text-emerald-300 font-black uppercase mb-0.5">
                            Sensor
                        </p>

                        <p class="text-white font-bold text-xs">
                            DHT11 Ready
                        </p>

                    </div>

                    <div class="bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-2xl">

                        <p class="text-[8px] text-emerald-300 font-black uppercase mb-0.5">
                            Hardware
                        </p>

                        <p class="text-white font-bold text-xs">
                            ESP8266 Ready
                        </p>

                    </div>

                </div>

            </div>

            <!-- CONNECTION -->

            <div class="bg-white/10 border border-white/20 p-8 rounded-[3rem] backdrop-blur-xl">

                <div class="flex items-center justify-between mb-6">

                    <h4 class="text-white font-bold uppercase tracking-widest text-[10px] text-emerald-300 underline underline-offset-8 font-digital">
                        STATUS_KONEKSI
                    </h4>

                    <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>

                </div>

                <div class="space-y-2">

                    <p class="text-3xl font-bold text-white uppercase tracking-tighter font-digital italic">
                        DEVICE_ONLINE
                    </p>

                    <p class="text-emerald-200/60 text-[10px] font-bold uppercase tracking-wider">
                        Data sensor berhasil diterima
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- CARDS -->

<div class="max-w-7xl mx-auto px-6 -mt-20 mb-12 relative z-30">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- TEMPERATURE -->

        <div class="stat-card bg-white p-10 rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-50 flex flex-col justify-between group">

            <p class="text-[10px] font-black text-slate-400 uppercase mb-4 tracking-[0.2em]">
                Suhu Udara
            </p>

            <div class="flex items-end gap-2">

                <span class="text-6xl font-bold text-slate-900 tracking-tighter font-digital italic">

                    {{ $latest ? $latest->temperature : '--' }}°

                </span>

                <span class="text-xs font-black text-rose-500 mb-2 uppercase tracking-widest">
                    Celsius
                </span>

            </div>

            <div class="mt-6 flex items-center justify-between">

                <span class="text-[10px] font-bold text-slate-300 uppercase">
                    Scale: °C
                </span>

                <span class="text-2xl">
                    🌡️
                </span>

            </div>

        </div>

        <!-- HUMIDITY -->

        <div class="stat-card bg-white p-10 rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-50 flex flex-col justify-between group">

            <p class="text-[10px] font-black text-slate-400 uppercase mb-4 tracking-[0.2em]">
                Kelembapan
            </p>

            <div class="flex items-end gap-2">

                <span class="text-6xl font-bold text-slate-900 tracking-tighter font-digital italic">

                    {{ $latest ? $latest->humidity : '--' }}%

                </span>

                <span class="text-xs font-black text-blue-500 mb-2 uppercase tracking-widest">
                    Humidity
                </span>

            </div>

            <div class="mt-6 flex items-center justify-between">

                <span class="text-[10px] font-bold text-slate-300 uppercase">
                    Scale: RH
                </span>

                <span class="text-2xl">
                    💧
                </span>

            </div>

        </div>

        <!-- STATUS -->

        <div class="stat-card bg-white p-10 rounded-[3rem] shadow-2xl shadow-slate-200/50 border-2 border-dashed border-emerald-100 flex flex-col items-center justify-center text-center">

            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-3xl mb-4">

                @if($warehouseStatus == 'AMAN')
                    ✅
                @elseif($warehouseStatus == 'TIDAK AMAN')
                    ⚠️
                @else
                    ⏳
                @endif

            </div>

            <p class="text-[10px] font-black text-slate-400 uppercase mb-2 tracking-[0.2em]">
                Kondisi Gudang
            </p>

            <h4 class="text-2xl font-bold uppercase tracking-tighter font-digital italic

                @if($warehouseStatus == 'AMAN')
                    text-emerald-500
                @elseif($warehouseStatus == 'TIDAK AMAN')
                    text-rose-500
                @else
                    text-slate-300
                @endif

            ">

                {{ $warehouseStatus }}

            </h4>

            <p class="text-[9px] font-bold text-slate-400 mt-3 uppercase tracking-widest">
                Smart Monitoring System
            </p>

        </div>

    </div>

</div>

<!-- CHART -->

<div class="max-w-7xl mx-auto px-6 pb-12">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 bg-white rounded-[3.5rem] shadow-xl p-10 border border-slate-50">

            <div class="flex justify-between items-center mb-10">

                <div>

                    <h4 class="text-2xl font-bold text-slate-900 uppercase tracking-tighter italic font-digital">
                        Analysis_Chart
                    </h4>

                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                        Real-time Visualization
                    </p>

                </div>

            </div>

            <div class="h-[350px] bg-slate-50 rounded-[2.5rem] border border-dashed border-slate-200 p-6">

                <canvas id="sensorChart"></canvas>

            </div>

        </div>

        <!-- SYSTEM LOG -->

        <div class="bg-white rounded-[3.5rem] shadow-xl p-10 border border-slate-50 flex flex-col">

            <h4 class="text-2xl font-bold text-slate-900 uppercase tracking-tighter mb-8 italic font-digital">
                System_Logs
            </h4>

            <div class="space-y-4">

                @foreach($history->take(5) as $item)

                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">

                        <div class="flex justify-between items-center">

                            <div>

                                <p class="font-bold text-slate-700 text-sm">
                                    {{ $item->temperature }}°C / {{ $item->humidity }}%
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $item->created_at }}
                                </p>

                            </div>

                            @if($item->temperature > 30 || $item->humidity > 85)

                                <span class="bg-rose-100 text-rose-600 text-xs font-bold px-3 py-1 rounded-full">
                                    ALERT
                                </span>

                            @else

                                <span class="bg-emerald-100 text-emerald-600 text-xs font-bold px-3 py-1 rounded-full">
                                    SAFE
                                </span>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

<!-- HISTORY -->

<div class="max-w-7xl mx-auto px-6 pb-24">

    <div class="bg-white rounded-[3rem] shadow-xl border border-slate-100 overflow-hidden">

        <div class="p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h3 class="text-3xl font-black tracking-tighter text-slate-900">
                    Monitoring History
                </h3>

                <p class="text-slate-400 text-sm mt-1">
                    Riwayat monitoring gudang
                </p>

            </div>

            <form method="GET" action="/monitoring">

                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="px-5 py-3 rounded-2xl border border-slate-200 bg-white shadow-sm font-semibold"
                >

                    <option value="">
                        Semua Data
                    </option>

                    <option value="aman" {{ $filter == 'aman' ? 'selected' : '' }}>
                        Aman
                    </option>

                    <option value="tidak_aman" {{ $filter == 'tidak_aman' ? 'selected' : '' }}>
                        Tidak Aman
                    </option>

                </select>

            </form>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="p-5 text-left text-xs uppercase tracking-wider text-slate-500">
                            No
                        </th>

                        <th class="p-5 text-left text-xs uppercase tracking-wider text-slate-500">
                            Temperature
                        </th>

                        <th class="p-5 text-left text-xs uppercase tracking-wider text-slate-500">
                            Humidity
                        </th>

                        <th class="p-5 text-left text-xs uppercase tracking-wider text-slate-500">
                            Fan
                        </th>

                        <th class="p-5 text-left text-xs uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="p-5 text-left text-xs uppercase tracking-wider text-slate-500">
                            Time
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($history as $item)

                        @php

                            $status = 'AMAN';

                            if (
                                $item->temperature > 30 ||
                                $item->humidity > 85
                            ) {

                                $status = 'TIDAK AMAN';
                            }

                        @endphp

                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition-all">

                            <td class="p-5 font-semibold">
                                {{ $loop->iteration }}
                            </td>

                            <td class="p-5 font-bold text-rose-500">
                                {{ $item->temperature }}°C
                            </td>

                            <td class="p-5 font-bold text-blue-500">
                                {{ $item->humidity }}%
                            </td>

                            <td class="p-5">
                                {{ $item->fan_status }}
                            </td>

                            <td class="p-5">

                                @if($status == 'AMAN')

                                    <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-xs font-bold">
                                        AMAN
                                    </span>

                                @else

                                    <span class="bg-rose-100 text-rose-700 px-4 py-2 rounded-full text-xs font-bold">
                                        TIDAK AMAN
                                    </span>

                                @endif

                            </td>

                            <td class="p-5 text-slate-500 text-sm">
                                {{ $item->created_at }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="p-10 text-center text-slate-400">

                                Tidak ada data monitoring

                            </td>

                        </tr>

                    @endforelse

                </tbody>

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
        @foreach($chartData as $item)
            "{{ $item->created_at->format('H:i:s') }}",
        @endforeach
    ];

    const temperatureData = [
        @foreach($chartData as $item)
            {{ $item->temperature }},
        @endforeach
    ];

    const humidityData = [
        @foreach($chartData as $item)
            {{ $item->humidity }},
        @endforeach
    ];

    const ctx = document.getElementById('sensorChart');

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: labels,

            datasets: [

                {
                    label: 'Temperature (°C)',

                    data: temperatureData,

                    borderColor: '#ef4444',

                    backgroundColor: 'rgba(239,68,68,0.1)',

                    borderWidth: 3,

                    tension: 0.4,

                    fill: true
                },

                {
                    label: 'Humidity (%)',

                    data: humidityData,

                    borderColor: '#3b82f6',

                    backgroundColor: 'rgba(59,130,246,0.1)',

                    borderWidth: 3,

                    tension: 0.4,

                    fill: true
                }

            ]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            scales: {

                y: {

                    beginAtZero: true
                }
            }
        }
    });

</script>

@endsection