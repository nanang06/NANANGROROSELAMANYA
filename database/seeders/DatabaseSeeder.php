<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🛠️ PERBAIKAN: Menghapus data test bawaan yang bikin error kolom 'name' & 'email'.
        // Sekarang diganti untuk memanggil UserSeeder agar otomatis membuat akun Admin & Warga kita.
        $this->call([
            UserSeeder::class,
        ]);
    }
}
