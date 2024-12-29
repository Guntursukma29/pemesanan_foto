<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\User;
use Midtrans\Config;
use App\Models\Pemesanan;
use App\Models\Videografi;
use App\Mail\ReminderEmail;
use Illuminate\Http\Request;
use App\Models\PemesananPromo;
use App\Models\PemesananVideografi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PemesananVideografiController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false;  // Pastikan sesuai dengan environment Anda
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Method untuk menampilkan riwayat pemesanan videografi
    public function index()
    {
        $pemesanans = PemesananVideografi::with(['user', 'paket'])->where('id_user', Auth::id())->get();
        return view('user.riwayat_videografi', compact('pemesanans'));
    }
    public function adminIndex()
    {
        $pemesanans = PemesananVideografi::with(['user', 'paket', 'fotografer'])->get();

        // Filter fotografer yang sedang tidak ditugaskan di Pemesanan, PemesananVideografi, dan PemesananPromo
        $fotografer = User::where('role', 'fotografer')
            ->whereDoesntHave('pemesananVideografi', function ($query) {
                $query->where('status_pemesanan', '!=', 'selesai');
            })
            ->whereDoesntHave('pemesanan', function ($query) {
                $query->where('status_pemesanan', '!=', 'selesai');
            })
            ->whereDoesntHave('pemesananPromo', function ($query) {
                $query->where('status_pemesanan', '!=', 'selesai');
            })
            ->get();

        return view('admin.pemesanan.videografi', compact('pemesanans', 'fotografer'));
    }



    public function assignFotografer(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_fotografer' => 'required|exists:users,id',
        ]);

        // Cek apakah fotografer sedang ditugaskan di PemesananVideografi
        $fotograferInUseVideografi = PemesananVideografi::where('id_fotografer', $request->id_fotografer)
            ->where('status_pemesanan', '!=', 'selesai')
            ->exists();

        // Cek apakah fotografer sedang ditugaskan di Pemesanan
        $fotograferInUsePemesanan = Pemesanan::where('id_fotografer', $request->id_fotografer)
            ->where('status_pemesanan', '!=', 'selesai')
            ->exists();

        // Cek apakah fotografer sedang ditugaskan di PemesananPromo
        $fotograferInUsePromo = PemesananPromo::where('id_fotografer', $request->id_fotografer)
            ->where('status_pemesanan', '!=', 'selesai')
            ->exists();

        if ($fotograferInUseVideografi || $fotograferInUsePemesanan || $fotograferInUsePromo) {
            return redirect()->route('admin.pemesanan.index')->with('error', 'Fotografer sedang ditugaskan di pesanan lain. Pilih fotografer lain.');
        }

        // Update data pemesanan
        $pemesanan = PemesananVideografi::findOrFail($id);
        $pemesanan->update([
            'id_fotografer' => $request->id_fotografer,
            'status_pemesanan' => 'proses', // Ubah status menjadi 'proses' setelah fotografer ditugaskan
        ]);

        return redirect()->route('admin.pemesanan.videografi.index')->with('success', 'Fotografer berhasil ditugaskan.');
    }





    // Method untuk membuat pemesanan videografi
    public function create($id)
    {
        $videografi = Videografi::findOrFail($id);
        $user = auth()->user();
        return view('user.order_videografi', compact('videografi', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'alamat' => 'required|string',
            'tempat' => 'required|in:Indoor,Outdoor',
            'id_paket' => 'required|exists:videografi,id',
            'paket_jenis' => 'required|in:special,platinum',
        ]);

        $userId = Auth::id();
        $order_id = 'ORDER-' . $userId . '-' . time();

        // Simpan pemesanan ke database
        $pemesanan = PemesananVideografi::create([
            'id_user' => $userId,
            'id_paket' => $request->id_paket,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'alamat' => $request->alamat,
            'tempat' => $request->tempat,
            'paket_jenis' => $request->paket_jenis,
            'status_pemesanan' => 'pending',
            'status_pembayaran' => 'belum bayar',
            'order_id' => $order_id,
        ]);

        return redirect()->route('pemesanans.videografi.index')->with('success', 'Pemesanan videografi berhasil dibuat.');
    }

    // Method untuk mengubah jadwal pemesanan
    public function ubahJadwal(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'tempat' => 'required|in:Indoor,Outdoor',
            'alamat' => 'required|string|max:255',
        ]);

        $pemesanan = PemesananVideografi::findOrFail($id);
        $pemesanan->update([
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'tempat' => $request->tempat,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pemesananvideografi.index')->with('success', 'Jadwal pemesanan berhasil diubah.');
    }

    // Method untuk menghapus pemesanan
    public function destroy($id)
    {
        $pemesanan = PemesananVideografi::findOrFail($id);
        $pemesanan->delete();

        return redirect()->route('pemesanans.videografi.index')->with('success', 'Pemesanan videografi berhasil dihapus.');
    }

    // Method untuk memproses pembayaran
    public function bayar(PemesananVideografi $pemesanan)
    {
        $paket = $pemesanan->paket;
        $harga = $pemesanan->paket_jenis === 'special'
        ? $paket->harga_special
        : $paket->harga_platinum;

        // Validasi harga
        if ($harga <= 0) {
            return redirect()->route('pemesanans.videografi.index')->with('error', 'Harga paket tidak valid.');
        }

        // Payload untuk Midtrans
        $payload = [
            'transaction_details' => [
                'order_id' => $pemesanan->order_id,
                'gross_amount' => $harga,
            ],
            'item_details' => [
                [
                    'id' => $paket->id,
                    'price' => $harga,
                    'quantity' => 1,
                    'name' => $paket->nama,
                ],
            ],
            'customer_details' => [
                'first_name' => $pemesanan->user->name,
                'email' => $pemesanan->user->email,
                'phone' => $pemesanan->user->phone ?? '',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($payload);
            return view('user.payment_videografi', compact('snapToken', 'pemesanan'));
        } catch (\Exception $e) {
            Log::error("Midtrans Error: " . $e->getMessage());
            return redirect()->route('pemesanans.videografi.index')->with('error', 'Gagal memproses pembayaran.');
        }
    }
    public function sendReminder()
    {
        // Ambil data pemesanan videografi
        $pemesananVideografi = PemesananVideografi::all();

        // Loop setiap pemesanan untuk mengirim email
        foreach ($pemesananVideografi as $order) {
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

        // Redirect ke route untuk pemesanan videografi
        return redirect()->route('admin.pemesanan.videografi.index')
            ->with('success', 'Reminder untuk pemesanan videografi berhasil dikirim.');
    }
    public function masukkanKodeFoto(Request $request, $id)
    {
        // Validasi input kode foto
        $request->validate([
            'code_foto' => 'required|string|max:255',
        ]);

        // Cari pemesanan berdasarkan ID
        $pemesanan = PemesananVideografi::findOrFail($id);

        // Update kode foto pada pemesanan
        $pemesanan->update([
            'code_foto' => $request->code_foto,
        ]);

        // Redirect ke route pemesanans.index dengan pesan sukses
        return redirect()->route('pemesanans.videografi.index')->with('success', 'Kode foto berhasil dimasukkan.');
    }

   
}