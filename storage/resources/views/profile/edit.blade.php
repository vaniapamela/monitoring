@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-[#f8fafc]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10">
            <h2 class="text-3xl font-extrabold tracking-tighter text-slate-900 uppercase">
                Pengaturan <span class="text-emerald-500">Profil</span>
            </h2>
            <p class="text-sm font-medium text-slate-500 mt-1">
                Kelola informasi akun, keamanan password, dan privasi data AgroMonitor Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 bg-white border border-slate-100 shadow-xl shadow-slate-200/50 rounded-[2rem] p-6 sm:p-10 transition-all hover:shadow-2xl hover:shadow-slate-200/60">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <span class="text-xl">👤</span>
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Informasi Akun</h3>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="space-y-8">
                
                <div class="bg-white border border-slate-100 shadow-xl shadow-slate-200/50 rounded-[2rem] p-6 sm:p-8 transition-all hover:shadow-2xl hover:shadow-slate-200/60">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                        <span class="text-xl">🔐</span>
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Keamanan</h3>
                    </div>
                    <div>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="bg-rose-50/50 border border-rose-100 shadow-xl shadow-rose-100/30 rounded-[2rem] p-6 sm:p-8 transition-all">
                    <div class="flex items-center gap-3 mb-4 pb-3 border-b border-rose-100">
                        <span class="text-xl">⚠️</span>
                        <h3 class="text-sm font-black text-rose-900 uppercase tracking-wider">Zona Bahaya</h3>
                    </div>
                    <div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection