@extends('layouts.app')

@section('content')

<h1>Dashboard Monitoring</h1>

<div class="dashboard">
    <div class="card">
        <h3>Suhu</h3>
        <p id="suhu">--°C</p>
    </div>

    <div class="card">
        <h3>Kelembapan</h3>
        <p id="kelembapan">--%</p>
    </div>

    <div class="card">
        <h3>Status</h3>
        <p id="status">Normal</p>
    </div>
<hr>

<h2>Kontrol Alat</h2>
<button>ON</button>
<button>OFF</button>

</div>

@endsection