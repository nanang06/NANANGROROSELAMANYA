<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
    ];

    /**
     * Penjelasan untuk bahan skripsi:
     * $fillable digunakan untuk keamanan (Mass Assignment Protection).
     * Kolom 'slug' digunakan untuk membuat URL yang ramah SEO (SEO Friendly).
     */
}
