<?php

namespace App\Mail;

use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiSuratSelesai extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    // Ambil data pengajuan surat saat email dipanggil
    public function __construct(Pengajuan $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SIP CIPULIR - Surat Layanan Anda Telah Selesai Terbit! 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.surat_selesai', // Mengarah ke file tampilan email html nanti
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
