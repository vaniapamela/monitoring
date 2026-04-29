<!DOCTYPE html>
<html>
<head>
    <title>Monitoring IoT</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<nav class="navbar">
    <h2 class="logo">AgroMonitor</h2>
    <div class="nav-links">
        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/monitoring">Monitoring</a>
        <a href="/contact">Contact</a>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

<script src="{{ asset('js/script.js') }}"></script>

</body>
</html>