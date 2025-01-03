<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\User;
use Midtrans\Config;
use App\Models\Fotografi;
use App\Models\Pemesanan;
use App\Mail\ReminderEmail;
use Illuminate\Http\Request;
use App\Models\PemesananPromo;
use App\Models\PemesananVideografi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PemesananController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false;  // Pastikan sesuai dengan environment Anda
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Method untuk menampilkan riwayat pemesanan
    public function index(Request $request)
    {
        $paket = $request->query('paket', 'special'); 
        $pemesanans = Pemesanan::with(['user', 'paket'])->where('id_user', Auth::id())->get();
        return view('user.riwayat', compact('pemesanans', 'paket'));
    }
    public function indexAdmin()
    {
        // Mengambil data pemesanan dengan relasi user, paket, dan fotografer
        $pemesanans = Pemesanan::with(['user', 'paket', 'fotografer'])->get();
        $totalHargaSpesial = $pemesanans
            ->where('paket_jenis', 'special')
            ->sum(fn ($item) => $item->paket->harga_special);

        $totalHargaPlatinum = $pemesanans
            ->where('paket_jenis', 'platinum')
            ->sum(fn ($item) => $item->paket->harga_platinum);
        

        // Mengambil fotografer yang tidak sedang ditugaskan di Pemesanan, PemesananVideografi, dan PemesananPromo yang statusnya bukan 'selesai'
        $fotografer = User::where('role', 'fotografer')
            ->whereDoesntHave('pemesanan', function ($query) {
                $query->where('status_pemesanan', '!=', 'selesai');
            })
            ->whereDoesntHave('pemesananVideografi', function ($query) {
                $query->where('status_pemesanan', '!=', 'selesai');
            })
            ->whereDoesntHave('pemesananPromo', function ($query) {
                $query->where('status_pemesanan', '!=', 'selesai');
            })
            ->get();
            $totalHargaKeseluruhan = $totalHargaSpesial + $totalHargaPlatinum;
        return view('admin.pemesanan.fotografi', compact('pemesanans', 'fotografer','totalHargaSpesial', 'totalHargaPlatinum', 'totalHargaKeseluruhan'));
    }




    // Method untuk membuat pemesanan
    public function create($id)
    {
        $fotografi = Fotografi::findOrFail($id);
        $user = auth()->user();
        return view('user.order_fotografi', compact('fotografi', 'user'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'alamat' => 'required|string',
            'tempat' => 'required|in:Indoor,Outdoor',
            'id_paket' => 'required|exists:fotografi,id',
            'paket_jenis' => 'required|in:special,platinum',
        ]);

        $userId = Auth::id();
        $order_id = 'ORDER-' . $userId . '-' . time();

        // Simpan pemesanan ke database
        $pemesanan = Pemesanan::create([
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

        return redirect()->route('pemesanans.index')->with('success', 'Pemesanan berhasil dibuat.');
    }
    public function ubahJadwal(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'tempat' => 'required|in:Indoor,Outdoor',
            'alamat' => 'required|string|max:255',
        ]);

        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update([
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'tempat' => $request->tempat,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pemesanans.index')->with('success', 'Jadwal berhasil diubah.');
    }
    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->delete();

        return redirect()->route('pemesanans.index')->with('success', 'Pemesanan berhasil dihapus.');
    }
    public function assignFotografer(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_fotografer' => 'required|exists:users,id',
        ]);

        // Cek apakah fotografer sedang ditugaskan di Pemesanan yang statusnya tidak selesai
        $fotograferInUsePemesanan = Pemesanan::where('id_fotografer', $request->id_fotografer)
            ->where('status_pemesanan', '!=', 'selesai')
            ->exists();

        // Cek apakah fotografer sedang ditugaskan di PemesananVideografi yang statusnya tidak selesai
        $fotograferInUseVideografi = PemesananVideografi::where('id_fotografer', $request->id_fotografer)
            ->where('status_pemesanan', '!=', 'selesai')
            ->exists();

        // Cek apakah fotografer sedang ditugaskan di PemesananPromo yang statusnya tidak selesai
        $fotograferInUsePromo = PemesananPromo::where('id_fotografer', $request->id_fotografer)
            ->where('status_pemesanan', '!=', 'selesai')
            ->exists();

        // Jika fotografer sedang ditugaskan di salah satu model dengan status belum selesai, beri peringatan
        if ($fotograferInUsePemesanan || $fotograferInUseVideografi || $fotograferInUsePromo) {
            return redirect()->route('admin.pemesanan.index')->with('error', 'Fotografer sedang ditugaskan di pesanan lain. Pilih fotografer lain.');
        }

        // Jika tidak ada masalah, update pemesanan dengan id_fotografer yang baru
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update([
            'id_fotografer' => $request->id_fotografer,
            'status_pemesanan' => 'proses', // Ubah status menjadi 'proses' setelah fotografer ditugaskan
        ]);

        // Redirect kembali ke halaman daftar pemesanan dengan pesan sukses
        return redirect()->route('admin.pemesanan.index')->with('success', 'Fotografer berhasil ditugaskan.');
    }

    public function bayar(Pemesanan $pemesanan)
    {
        $paket = $pemesanan->paket;
        $harga = $pemesanan->paket_jenis === 'special'
        ? $paket->harga_special
        : $paket->harga_platinum;

        // Validasi harga
        if ($harga <= 0) {
            return redirect()->route('pemesanans.index')->with('error', 'Harga paket tidak valid.');
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
            return view('user.payment', compact('snapToken', 'pemesanan'));
        } catch (\Exception $e) {
            Log::error("Midtrans Error: " . $e->getMessage());
            return redirect()->route('pemesanans.index')->with('error', 'Gagal memproses pembayaran.');
        }
    }
    public function sendReminder()
    {
        // Ambil data pemesanan biasa
        $pemesanan = Pemesanan::all();

        // Loop setiap pemesanan untuk mengirim email
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

        // Redirect ke route untuk pemesanan biasa
        return redirect()->route('admin.pemesanan.index')->with('success', 'Reminder untuk pemesanan berhasil dikirim.');
    }
    public function masukkanKodeFoto(Request $request, $id)
    {
        // Validasi input kode foto
        $request->validate([
            'code_foto' => 'required|string|max:255',
        ]);

        // Cari pemesanan berdasarkan ID
        $pemesanan = Pemesanan::findOrFail($id);

        // Update kode foto pada pemesanan
        $pemesanan->update([
            'code_foto' => $request->code_foto,
            'status_pemesanan' => 'batal'
        ]);

        // Redirect ke route pemesanans.index dengan pesan sukses
        return redirect()->route('pemesanans.index')->with('success', 'Kode foto berhasil dimasukkan.');
    }

}
