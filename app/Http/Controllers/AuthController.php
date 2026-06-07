<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * PROSES REGISTRASI WARGA BARU
     */
    public function prosesRegister(Request $request)
    {
        // 1. Validasi Inputan (Ditambah validasi untuk Nama)
        $request->validate([
            'name' => 'required|string|max:255', // Nama wajib diisi
            'nik' => 'required|string|size:16|unique:users,nik',
            'password' => 'required|string|min:6'
        ], [
            // Pesan error custom berbahasa Indonesia
            'nik.unique' => 'Maaf, NIK ini sudah terdaftar. Silakan langsung login.',
            'nik.size' => 'NIK harus berjumlah tepat 16 digit.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        // 2. Simpan Data ke Tabel Users (Ditambah penyimpanan Nama)
        $user = User::create([
            'name' => $request->name, // Menyimpan input nama ke database
            'nik' => $request->nik,
            'password' => Hash::make($request->password),
            'role' => 'warga',
        ]);

        // 3. Langsung Login-kan user setelah berhasil daftar
        Auth::login($user);

        // 4. Arahkan ke dashboard warga
        return redirect('/warga/dashboard')->with('success', 'Registrasi berhasil! Selamat datang di SIP CIPULIR.');
    }

    /**
     * PROSES LOGIN (ADMIN & WARGA)
     */
    public function prosesLogin(Request $request)
    {
        // 1. Validasi Inputan
        $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);

        // 2. Cek NIK dan Password di Database
        $credentials = [
            'nik' => $request->nik,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            // Jika NIK dan Password Cocok, buat sesi baru
            $request->session()->regenerate();

            // 3. Cek Role, arahkan ke dashboard yang sesuai
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/warga/dashboard');
            }
        }

        // Jika Gagal Login (NIK/Password Salah)
        return back()->withErrors([
            'nik' => 'NIK atau Password yang Anda masukkan salah.',
        ])->onlyInput('nik');
    }

    /**
     * PROSES LOGOUT
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus sesi keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembalikan ke halaman utama (Beranda Publik) agar lebih elegan
        return redirect('/');
    }
}
