@extends('layouts.app')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f0fdf4; overflow-x: hidden; }
    
    .contact-hero {
        background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
        position: relative;
    }

    /* Animasi Floating untuk Icon */
    .floating {
        animation: floating 3s ease-in-out infinite;
    }
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }

    /* Glassmorphism Effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(16, 185, 129, 0.1);
    }
</style>

<div class="min-h-screen pb-20">
    
    <div class="contact-hero h-[450px] flex items-center justify-center text-center px-6 overflow-hidden">
        <div class="max-w-4xl relative z-10" data-aos="zoom-out" data-aos-duration="1000">
            <h2 class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.5em] mb-4">Get In Touch</h2>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white uppercase tracking-tighter mb-6 leading-tight">
                Hubungi <span class="text-emerald-400">Tim Ahli</span> Kami
            </h1>
            <p class="text-emerald-100/70 text-sm md:text-lg font-medium max-w-2xl mx-auto leading-relaxed">
                Butuh bantuan teknis seputar sensor <span class="text-white font-bold">DHT11</span> atau integrasi <span class="text-white font-bold">Blynk</span>? Kami siap membantu mengoptimalkan gudang pintar Anda.
            </p>
        </div>

        <div class="absolute top-20 left-10 w-32 h-32 bg-emerald-500/20 rounded-full blur-3xl floating"></div>
        <div class="absolute bottom-10 right-10 w-40 h-40 bg-emerald-400/10 rounded-full blur-3xl floating" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 -mt-24 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="glass-card p-8 rounded-[2.5rem] shadow-xl transition-all hover:shadow-emerald-200/50 group" 
                     data-aos="fade-right" data-aos-delay="100">
                    <div class="bg-emerald-100 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">📍</div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kantor Pusat</h3>
                    <p class="text-base font-bold text-slate-800 leading-relaxed">
                        Jl. Agroteknologi No. 123, <br>Kawasan Industri Hijau, Jakarta
                    </p>
                </div>

                <div class="glass-card p-8 rounded-[2.5rem] shadow-xl transition-all hover:shadow-emerald-200/50 group" 
                     data-aos="fade-right" data-aos-delay="200">
                    <div class="bg-blue-100 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">📞</div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Layanan Teknis</h3>
                    <p class="text-lg font-black text-slate-800">+62 831 6425 3815</p>
                    <p class="text-[10px] text-emerald-600 font-bold uppercase mt-2">Tersedia via WhatsApp</p>
                </div>

                <div class="glass-card p-8 rounded-[2.5rem] shadow-xl transition-all hover:shadow-emerald-200/50 group" 
                     data-aos="fade-right" data-aos-delay="300">
                    <div class="bg-rose-100 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">✉️</div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Email Support</h3>
                    <p class="text-base font-bold text-slate-800">support@agromonitor.id</p>
                </div>
            </div>

            <div class="lg:col-span-2 glass-card rounded-[3rem] shadow-2xl p-8 md:p-14" 
                 data-aos="fade-up" data-aos-delay="400">
                <div class="mb-10">
                    <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight mb-4">
                        Kirim <span class="text-emerald-500">Pesan</span>
                    </h2>
                    <p class="text-slate-500 text-sm font-medium italic border-l-4 border-emerald-500 pl-4">
                        Respon cepat dijamin dalam waktu kurang dari 24 jam.
                    </p>
                </div>

                <form action="#" method="POST" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block group-focus-within:text-emerald-500 transition-colors">Nama Lengkap</label>
                            <input type="text" placeholder="Vania Utama" 
                                class="w-full px-6 py-4 bg-slate-50/50 border border-slate-200 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all">
                        </div>
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block group-focus-within:text-emerald-500 transition-colors">Alamat Email</label>
                            <input type="email" placeholder="vania@email.com" 
                                class="w-full px-6 py-4 bg-slate-50/50 border border-slate-200 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all">
                        </div>
                    </div>

                    <div class="group">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block group-focus-within:text-emerald-500 transition-colors">Subjek Kebutuhan</label>
                        <select class="w-full px-6 py-4 bg-slate-50/50 border border-slate-200 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all appearance-none cursor-pointer">
                            <option>🔧 Masalah Hardware (ESP8266/DHT11)</option>
                            <option>💻 Integrasi Dashboard Web</option>
                            <option>🌱 Konsultasi Cold Storage</option>
                            <option>❓ Tanya Lainnya</option>
                        </select>
                    </div>

                    <div class="group">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block group-focus-within:text-emerald-500 transition-colors">Detail Pesan</label>
                        <textarea rows="5" placeholder="Jelaskan kendala atau pertanyaan Anda secara mendetail..." 
                            class="w-full px-6 py-4 bg-slate-50/50 border border-slate-200 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all resize-none"></textarea>
                    </div>

                    <button type="submit" 
                        class="w-full bg-emerald-600 text-white py-5 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-emerald-500 transform hover:-translate-y-2 transition-all shadow-xl shadow-emerald-900/20 active:scale-95">
                        Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true, // Animasi hanya berjalan sekali saat scroll
        duration: 800,
        offset: 100
    });
</script>
@endsection