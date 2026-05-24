@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden">
        
        <div class="p-8 bg-gradient-to-r from-slate-900 to-slate-800 flex justify-between items-center text-white">
            <div>
                <h1 class="text-2xl font-bold font-mono">PANEL ADMIN: MANAJEMEN USER</h1>
                <p class="text-slate-400 text-xs mt-1">Aktifkan atau nonaktifkan hak akses penyewa gudang hortikultura</p>
            </div>
            <span class="bg-emerald-500 text-slate-900 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Sistem Utama</span>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 m-6 text-emerald-700 text-sm font-bold rounded-r-xl">
                ✨ {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto p-6">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-black uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Nama</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role Saat Ini</th>
                        <th class="p-4 text-center">Aksi Perubahan Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 text-slate-800 font-bold">{{ $user->name }}</td>
                            <td class="p-4 text-slate-500 font-mono text-xs">{{ $user->email }}</td>
                            <td class="p-4">
                                @if($user->role == 'admin')
                                    <span class="bg-purple-100 text-purple-700 text-[10px] font-black px-2.5 py-1 rounded-md uppercase">👑 Admin</span>
                                @elseif($user->role == 'tenant')
                                    <span class="bg-emerald-100 text-emerald-700 text-[10px] font-black px-2.5 py-1 rounded-md uppercase">🟢 Penyewa (User 1)</span>
                                @else
                                    <span class="bg-slate-100 text-slate-500 text-[10px] font-black px-2.5 py-1 rounded-md uppercase">⚪ Orang Luar (User 2)</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if($user->role == 'admin')
                                    <span class="text-xs text-slate-400 italic">Tidak dapat diubah</span>
                                @elseif($user->role == 'guest')
                                    <form action="{{ route('admin.users.make-tenant', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-md shadow-emerald-700/10">
                                            🔑 Aktifkan Jadi Penyewa
                                        </button>
                                    </form>
                                @elseif($user->role == 'tenant')
                                    <form action="{{ route('admin.users.make-guest', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-bold px-4 py-2 rounded-xl transition-all">
                                            🛑 Cabut Hak Akses
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection