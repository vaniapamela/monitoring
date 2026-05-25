<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceModel;
use App\Models\User; // Pastikan ini ada dan folder/file benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        
       $users = User::with(['sensorData'])
    ->where('id', '!=', auth()->id())
    ->get();

        $totalLogins = User::sum('login_count');
        $usersLoggedInToday = User::whereDate('last_login_at', today())->count();

        return view('admin.users.index', compact('users', 'totalLogins', 'usersLoggedInToday'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:3',
        'role' => 'required',
        'token' => 'required|max:5|unique:users,token',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
        'token' => strtoupper($request->token),
    ]);

    return back()->with('success', 'User berhasil ditambahkan');
}
     
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'token' => $request->token 
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User & Device berhasil diupdate!');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->role = ($user->role === 'tenant') ? 'guest' : 'tenant';
        $user->save();

        $pesan = ($user->role === 'tenant') ? "{$user->name} kini jadi Penyewa." : "Akses {$user->name} dicabut.";

        return redirect()->route('admin.users.index')->with('success', $pesan);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun telah dihapus.');
    }
}
