<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\User;
use App\Models\Pemesanan;
use App\Models\PemesananVideografi;
use App\Models\PemesananPromo;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index()
    {
        // Ambil semua data ulasan beserta relasinya
        $ulasan = Ulasan::with([
            'pemesanan.fotografi',
            'pemesananVideografi.videografi',
            'pemesananPromo.promo'
        ])->get();
        
        return view('admin.ulasan.index', compact('ulasan'));
    }

    public function create()
    {
        // Ambil data user, pemesanan, pemesanan videografi, dan pemesanan promo
        $users = User::all();
        $pemesanan = Pemesanan::all();
        $pemesananVideografi = PemesananVideografi::all();
        $pemesananPromo = PemesananPromo::all();

        return view('admin.ulasan.create', compact('users', 'pemesanan', 'pemesananVideografi', 'pemesananPromo'));
    }

        public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pemesanan_id' => 'nullable|exists:pemesanan,id',
            'pemesanan_videografi_id' => 'nullable|exists:pemesananvideografi,id',
            'pemesanan_promo_id' => 'nullable|exists:pemesananpromo,id',
            'bintang' => 'required|integer|min:1|max:5',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string',
        ]);

        // Ambil user yang sedang login
        $user_id = auth()->id(); // Mendapatkan ID pengguna yang sedang login

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('ulasan_foto', 'public');
        }

        // Simpan data ulasan
        $ulasan = Ulasan::create([
            'user_id' => $user_id, // Menggunakan user_id yang didapat dari pengguna yang sedang login
            'pemesanan_id' => $request->pemesanan_id ?? null, // Jika tidak ada, set null
            'pemesanan_videografi_id' => $request->pemesanan_videografi_id ?? null,
            'pemesanan_promo_id' => $request->pemesanan_promo_id ?? null,
            'foto' => $fotoPath,
            'bintang' => $request->bintang,
            'catatan' => $request->catatan,
            'status' => 'tampilkan',
        ]);

        // Tentukan route tujuan berdasarkan jenis pemesanan yang ada (jika ada)
        if ($request->pemesanan_id) {
            return redirect()->route('pemesanans.index')->with('success', 'Ulasan berhasil ditambahkan.');
        } elseif ($request->pemesanan_videografi_id) {
            return redirect()->route('pemesanans.videografi.index')->with('success', 'Ulasan berhasil ditambahkan.');
        } elseif ($request->pemesanan_promo_id) {
            return redirect()->route('pemesanans.promo.index')->with('success', 'Ulasan berhasil ditambahkan.');
        }

        // Jika tidak ada pemesanan yang valid, arahkan ke halaman ulasan umum
        return redirect()->route('ulasan.index')->with('success', 'Ulasan berhasil ditambahkan.');
    }

    public function sembunyikan($id)
    {
        // Cari ulasan berdasarkan ID
        $ulasan = Ulasan::findOrFail($id);
        
        // Ubah status menjadi "sembunyikan"
        $ulasan->status = 'sembunyikan';
        $ulasan->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Ulasan berhasil disembunyikan.');
    }

}

