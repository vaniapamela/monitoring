<!DOCTYPE html>
<html>
<head>
    <title>Laporan AgroMonitor</title>
    <style>
        body { font-family: sans-serif; color: #334155; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #10b981; padding-bottom: 10px; }
        .title { font-size: 20px; font-weight: bold; color: #064e3b; text-transform: uppercase; }
        .meta-table { width: 100%; margin-bottom: 20px; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { background-color: #f1f5f9; padding: 10px; text-align: left; font-size: 11px; text-transform: uppercase; color: #475569; }
        .data-table td { padding: 10px; border-bottom: 1px solid #e2e8f0; }
        .badge-safe { color: #15803d; font-weight: bold; }
        .badge-danger { color: #b91c1c; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">AgroMonitor - Laporan Riwayat Gudang</div>
        <p style="margin: 5px 0 0 0; color: #64748b;">Sistem Otomasi Tanaman & Penyimpanan Hortikultura</p>
    </div>

    <table class="meta-table">
        <tr>
            <td><strong>Nama Pemilik:</strong> {{ $user->name }}</td>
            <td style="text-align: right;"><strong>Filter Status:</strong> {{ $filter ? strtoupper(str_replace('_', ' ', $filter)) : 'SEMUA DATA' }}</td>
        </tr>
        <tr>
            <td><strong>Email Akun:</strong> {{ $user->email }}</td>
            <td style="text-align: right;"><strong>Waktu Cetak:</strong> {{ now()->format('d M Y H:i') }} WIB</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Suhu (°C)</th>
                <th>Kelembapan (%)</th>
                <th>Status Kipas</th>
                <th>Kondisi</th>
                <th>Waktu Log</th>
            </tr>
        </thead>
        <tbody>
            @foreach($history as $item)
                @php
                    $isAman = $item->temperature <= 30 && $item->humidity <= 85;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="color: #ef4444; font-weight: bold;">{{ $item->temperature }}°C</td>
                    <td style="color: #3b82f6; font-weight: bold;">{{ $item->humidity }}%</td>
                    <td>{{ $item->fan_status ?? 'OFF' }}</td>
                    <td>
                        <span class="{{ $isAman ? 'badge-safe' : 'badge-danger' }}">
                            {{ $isAman ? 'AMAN' : 'TIDAK AMAN' }}
                        </span>
                    </td>
                    <td>{{ $item->created_at->format('d M Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>