<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validasi data input dari form kontak
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string',
            'message' => 'required|string|min:5',
        ]);

        try {
            // Mengirim email ke agromonitor@gmail.com menggunakan file Mailable
            Mail::to('agrocorporateo@gmail.com')->send(new ContactMessageMail($validatedData));

            return back()->with('success', 'Pesan Anda berhasil dikirim langsung ke Gmail kami!');
        } catch (\Exception $e) {
            // Mengembalikan error jika SMTP Gmail (.env) belum dikonfigurasi dengan benar
            return back()->with('error', 'Gagal mengirim pesan. Silakan periksa konfigurasi SMTP atau jaringan.');
        }
    }
}