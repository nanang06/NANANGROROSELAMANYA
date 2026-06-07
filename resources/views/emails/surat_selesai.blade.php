<!DOCTYPE html>
<html>
<head>
    <title>Surat Selesai</title>
</head>
<body style="font-family: sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e3e3e3; border-radius: 10px;">
        <h2 style="color: #003366;">Halo, {{ $pengajuan->warga->nama_lengkap }}!</h2>
        <p>Kabar baik! Permohonan dokumen Anda pada sistem <strong>SIP CIPULIR</strong> telah selesai diproses dan diterbitkan oleh Admin Kelurahan Cipulir.</p>

        <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
            <tr>
                <td style="padding: 5px 0; font-weight: bold; width: 150px;">Jenis Surat:</td>
                <td style="padding: 5px 0;">{{ $pengajuan->jenisSurat->nama_surat }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; font-weight: bold;">Catatan Admin:</td>
                <td style="padding: 5px 0; color: #666;"><i>"{{ $pengajuan->keterangan_admin ?? '-' }}"</i></td>
            </tr>
        </table>

        <p>Silakan login ke akun SIP CIPULIR Anda dan masuk ke menu <strong>Riwayat Pengajuan Surat</strong> untuk mengunduh dokumen PDF resmi Anda.</p>

        <p style="margin-top: 30px;">Salam hangat,<br><strong>Aparatur Kelurahan Cipulir</strong></p>
    </div>
</body>
</html>
