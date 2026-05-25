@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="bg-emerald-100 p-4 rounded-2xl text-xl">✅</div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Login Hari Ini</p>
                <h3 class="text-xl font-black text-slate-900">{{ $usersLoggedInToday ?? 0 }} Pengguna</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="bg-amber-100 p-4 rounded-2xl text-xl">👤</div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total User</p>
                <h3 class="text-xl font-black text-slate-900">{{ $users->count() ?? 0 }} Pengguna</h3>
            </div>
        </div>
    </div>

    <div class="mb-6 flex justify-end">
        <button onclick="toggleModal('modal-add')" class="bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-black px-5 py-3 rounded-xl transition-all shadow-md flex items-center gap-2 uppercase tracking-wider">
            ➕ Tambah Pengguna Baru
        </button>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden">
        <div class="p-8 bg-gradient-to-r from-slate-900 to-slate-800 text-white">
            <h1 class="text-2xl font-bold font-mono">PANEL ADMIN: MANAJEMEN USER</h1>
            <p class="text-slate-400 text-xs mt-1">Data pengguna, akses, dan pengelolaan sistem hortikultura</p>
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
                        <th class="p-4">Role</th>
                        <th class="p-4 text-center">Status Akses</th>
                        <th class="p-4 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 text-slate-800 font-bold">{{ $user->name }}</td>
                            <td class="p-4 text-slate-500 font-mono text-xs">{{ $user->email }}</td>
                            <td class="p-4">
                                @if($user->role == 'admin') <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-md text-[10px] font-black uppercase">👑 Admin</span>
                                @elseif($user->role == 'tenant') <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-md text-[10px] font-black uppercase">🟢 Penyewa</span>
                                @else <span class="bg-slate-100 text-slate-500 px-2 py-1 rounded-md text-[10px] font-black uppercase">⚪ Guest</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if($user->role !== 'admin')
                                    <form action="{{ url('admin/users/' . $user->id . '/toggle') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs font-bold px-4 py-2 rounded-xl transition-all {{ $user->role == 'guest' ? 'bg-emerald-600 text-white' : 'bg-rose-100 text-rose-700' }}">
                                            {{ $user->role == 'guest' ? '🔑 Aktifkan' : '🛑 Cabut Akses' }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button type="button" 
                                        onclick="openEditModal({{ json_encode($user) }}, '{{ $user->devices->first()->token ?? '' }}')" 
                                        class="bg-amber-100 text-amber-700 px-3 py-2 rounded-xl text-xs font-bold hover:bg-amber-200">
                                        ✏️ Edit
                                    </button>
                                    @if($user->role !== 'admin')
                                        <form action="{{ url('admin/users/' . $user->id) }}" method="POST" onsubmit="return confirm('Hapus user?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-slate-100 text-slate-600 px-3 py-2 rounded-xl text-xs font-bold hover:bg-rose-600 hover:text-white">🗑️ Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-add" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md m-4">
        <div class="p-6 bg-slate-900 text-white flex justify-between rounded-t-[2rem]">
            <h3 class="font-bold text-sm">➕ TAMBAH USER BARU</h3>
            <button onclick="toggleModal('modal-add')">✕</button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="text" name="name" placeholder="Nama Lengkap" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            <select name="role" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                <option value="tenant">Penyewa (Tenant)</option>
                <option value="guest">Orang Luar (Guest)</option>
            </select>
            <button type="submit" class="w-full py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-xs">SIMPAN</button>
        </form>
    </div>
</div>

<div id="modal-edit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md m-4">
        <div class="p-6 bg-slate-900 text-white flex justify-between rounded-t-[2rem]">
            <h3 class="font-bold text-sm">✏️ EDIT USER</h3>
            <button onclick="toggleModal('modal-edit')">✕</button>
        </div>
        <form id="form-edit" method="POST" class="p-6 space-y-4">
            @csrf @method('PUT')
            <input type="text" name="name" id="edit-name" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            <input type="email" name="email" id="edit-email" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            <input type="text" name="token" id="edit-token" placeholder="Token Perangkat" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            <input type="password" name="password" placeholder="Password Baru (Opsional)" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            <button type="submit" class="w-full py-2.5 bg-amber-600 text-white rounded-xl font-bold text-xs">UPDATE</button>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) { 
        document.getElementById(id).classList.toggle('hidden'); 
    }

    function openEditModal(user, token) {
        document.getElementById('edit-name').value = user.name;
        document.getElementById('edit-email').value = user.email;
        document.getElementById('edit-token').value = token;
        document.getElementById('form-edit').action = `/admin/users/${user.id}`;
        toggleModal('modal-edit');
    }
</script>
@endsection