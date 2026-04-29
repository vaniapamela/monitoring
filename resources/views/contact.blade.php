@extends('layouts.app')

@section('content')

<h1>Contact</h1>

<p>Email: kamu@email.com</p>

<form>
    <input type="text" placeholder="Nama"><br><br>
    <input type="email" placeholder="Email"><br><br>
    <textarea placeholder="Pesan"></textarea><br><br>
    <button>Kirim</button>
</form>

@endsection