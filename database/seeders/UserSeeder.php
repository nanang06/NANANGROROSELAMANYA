<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Membuat Akun Admin Kelurahan
        User::create([
            'nik' => 'admincipulir', // Kita pakai string khusus agar mudah diingat
            'password' => Hash::make('admin123'), // Hash::make berfungsi mengenkripsi password
            'role' => 'admin',
        ]);

        // 2. Membuat 1 Akun Warga (Untuk bahan percobaan login nanti)
        User::create([
            'nik' => '3174000011112222',
            'password' => Hash::make('warga123'),
            'role' => 'warga',
        ]);
    }
}
