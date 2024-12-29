<?php
namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Mail\ReminderEmail;
use App\Models\PemesananPromo;
use App\Models\PemesananVideografi;
use Illuminate\Support\Facades\Mail;

class ReminderController extends Controller
{
    public function sendReminder($type)
    {
        // Menentukan data pemesanan berdasarkan tipe
        switch ($type) {
            case 'videografi':
                $pemesanan = PemesananVideografi::all();
                $route = 'admin.pemesanan.videografi.index';
                break;
            case 'promo':
                $pemesanan = PemesananPromo::all();
                $route = 'admin.pemesanan.promo.index';
                break;
            default:
                $pemesanan = Pemesanan::all();
                $route = 'admin.pemesanan.index';
                break;
        }

        // Kirim email untuk setiap pemesanan
        foreach ($pemesanan as $order) {
            // Ambil data user terkait
            $user = $order->user;

            // Ambil nama paket sesuai kolom yang tersedia
            $namaPaket = $order->nama ?? $order->paket->nama ?? 'Paket Tidak Diketahui';

            // Data untuk email
            $data = [
                'name' => $user->name, // Nama pengguna
                'Paket' => $namaPaket, // Nama paket pemesanan
                'tanggal' => $order->tanggal, // Tanggal pemesanan
                'jam' => $order->jam, // Jam pemesanan
                'tempat' => $order->tempat, // Tempat pemesanan
            ];

            // Kirim email
            Mail::to($user->email)->send(new ReminderEmail($data));
        }

        // Redirect ke halaman sesuai tipe
        return redirect()->route($route)
            ->with('success', 'Reminder untuk pemesanan berhasil dikirim.');
    }
}
