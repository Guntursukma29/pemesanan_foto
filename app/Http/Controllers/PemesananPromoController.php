<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\User;
use Midtrans\Config;
use App\Models\Promo;
use App\Models\Pemesanan;
use App\Mail\ReminderEmail;
use Illuminate\Http\Request;
use App\Models\PemesananPromo;
use App\Models\PemesananVideografi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PemesananPromoController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false;  // Pastikan sesuai dengan environment Anda
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Method untuk menampilkan riwayat pemesanan promo
    public function index()
    {
        $pemesanans = PemesananPromo::with(['user', 'promo'])->where('id_user', Auth::id())->get();
        return view('user.riwayat_promo', compact('pemesanans'));
    }


    public function adminIndex()
    {
        $pemesanans = PemesananPromo::with(['user', 'promo', 'fotografer'])->get();
        $totalHargaSpesial = $pemesanans
            ->where('paket_jenis', 'special')
            ->sum(fn ($item) => $item->paket->harga_special);

        $totalHargaPlatinum = $pemesanans
            ->where('paket_jenis', 'platinum')
            ->sum(fn ($item) => $item->paket->harga_platinum);

        // Filter fotografer yang belum ditugaskan di semua pemesanan (promo, videografi, dan lainnya)
        $fotografer = User::where('role', 'fotografer')
            ->whereDoesntHave('pemesananPromo', function ($query) {
                $query->where('status_pemesanan', '!=', 'selesai');
            })
            ->whereDoesntHave('pemesananVideografi', function ($query) {
                $query->where('status_pemesanan', '!=', 'selesai');
            })
            ->whereDoesntHave('pemesanan', function ($query) {
                $query->where('status_pemesanan', '!=', 'selesai');
            })
            ->get();
            $totalHargaKeseluruhan = $totalHargaSpesial + $totalHargaPlatinum;

        return view('admin.pemesanan.promo', compact('pemesanans', 'fotografer', 'fotografer','totalHargaSpesial', 'totalHargaPlatinum', 'totalHargaKeseluruhan'));
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
        $pemesanan = PemesananPromo::findOrFail($id);
        $pemesanan->update([
            'id_fotografer' => $request->id_fotografer,
            'status_pemesanan' => 'proses', // Ubah status menjadi 'proses' setelah fotografer ditugaskan
        ]);

        
        return redirect()->route('admin.pemesanan.promo.index')->with('success', 'Fotografer berhasil ditugaskan.');
    }


    // Method untuk membuat pemesanan promo
    public function create($id)
    {
        $promo = Promo::findOrFail($id);
        $user = auth()->user();
        return view('user.order_promo', compact('promo', 'user'));
    }

    public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'jam' => 'required',
        'alamat' => 'required|string',
        'tempat' => 'required|in:Indoor,Outdoor',
        'id_paket' => 'required|exists:promo,id',
    ]);

    $userId = Auth::id();
    $order_id = 'ORDER-' . $userId . '-' . time() . '-' . uniqid();

    // Simpan pemesanan ke database
    $pemesanan = PemesananPromo::create([
        'id_user' => $userId,
        'id_paket' => $request->id_paket,
        'tanggal' => $request->tanggal,
        'jam' => $request->jam,
        'alamat' => $request->alamat,
        'tempat' => $request->tempat,
        'status_pemesanan' => 'pending',
        'status_pembayaran' => 'belum bayar',
        'order_id' => $order_id,
    ]);

    return redirect()->route('pemesanans.promo.index')->with('success', 'Pemesanan promo berhasil dibuat.');
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

        $pemesanan = PemesananPromo::findOrFail($id);
        $pemesanan->update([
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'tempat' => $request->tempat,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pemesanans.promo.index')->with('success', 'Jadwal pemesanan berhasil diubah.');
    }

    // Method untuk menghapus pemesanan
    public function destroy($id)
    {
        $pemesanan = PemesananPromo::findOrFail($id);
        $pemesanan->delete();

        return redirect()->route('pemesanans.promo.index')->with('success', 'Pemesanan promo berhasil dihapus.');
    }

    // Method untuk memproses pembayaran
    public function bayar(PemesananPromo $pemesanan)
    {
        $paket = $pemesanan->promo;
        $harga = $paket->harga;

        // Validasi harga
        if ($harga <= 0) {
            return redirect()->route('pemesanans.promo.index')->with('error', 'Harga paket tidak valid.');
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
            return view('user.payment_promo', compact('snapToken', 'pemesanan'));
        } catch (\Exception $e) {
            Log::error("Midtrans Error: " . $e->getMessage());
            return redirect()->route('pemesanans.promo.index')->with('error', 'Gagal memproses pembayaran.');
        }
    }
    public function sendReminder()
    {
        // Ambil data pemesanan promo
        $pemesananPromo = PemesananPromo::all();

        // Loop setiap pemesanan untuk mengirim email
        foreach ($pemesananPromo as $order) {
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

        // Redirect ke route untuk pemesanan promo
        return redirect()->route('admin.pemesanan.promo.index')
            ->with('success', 'Reminder untuk pemesanan promo berhasil dikirim.');
    }
    public function masukkanKodeFoto(Request $request, $id)
    {
        // Validasi input kode foto
        $request->validate([
            'code_foto' => 'required|string|max:255',
        ]);

        // Cari pemesanan berdasarkan ID
        $pemesanan = PemesananPromo::findOrFail($id);

        // Update kode foto pada pemesanan
        $pemesanan->update([
            'code_foto' => $request->code_foto,
            'status_pemesanan' => 'batal'
        ]);

        // Redirect ke route pemesanans.index dengan pesan sukses
        return redirect()->route('pemesanans.promo.index')->with('success', 'Kode foto berhasil dimasukkan.');
    }


    
}
