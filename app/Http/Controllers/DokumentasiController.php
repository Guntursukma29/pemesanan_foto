<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\PemesananPromo;
use App\Models\PemesananVideografi;

class DokumentasiController extends Controller
{
    public function indexFotografi()
    {
        $pemesanans = Pemesanan::with(['user', 'paket', 'fotografer'])->get();
        return view('admin.dokumentasi.fotografi', compact('pemesanans'));
    }
    public function indexPromo()
    {
        $pemesanans = PemesananPromo::with(['user', 'promo', 'fotografer'])->get();

        return view('admin.dokumentasi.promo', compact('pemesanans'));
    }
    public function indexVideografi()
    {
        $pemesanans = PemesananVideografi::with(['user', 'paket', 'fotografer'])->get();

        return view('admin.dokumentasi.videografi', compact('pemesanans'));
    }
}
