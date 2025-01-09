<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\PemesananPromo;
use App\Models\PemesananVideografi;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pemesanansFotografi = Pemesanan::with(['user', 'paket', 'fotografer'])->get();

        // Hitung total pendapatan fotografi
        $totalHargaSpesialFotografi = $pemesanansFotografi
            ->where('paket_jenis', 'special')
            ->sum(fn($item) => $item->paket->harga_special);

        $totalHargaPlatinumFotografi = $pemesanansFotografi
            ->where('paket_jenis', 'platinum')
            ->sum(fn($item) => $item->paket->harga_platinum);

        $totalPendapatanFotografi = $totalHargaSpesialFotografi + $totalHargaPlatinumFotografi;

        // Ambil data pemesanan videografi berdasarkan tahun dan bulan
        $pemesanansVideografi = PemesananVideografi::with(['user', 'paket', 'fotografer'])->get();

        // Hitung total pendapatan videografi
        $totalHargaSpesialVideografi = $pemesanansVideografi
            ->where('paket_jenis', 'special')
            ->sum(fn($item) => $item->paket->harga_special);

        $totalHargaPlatinumVideografi = $pemesanansVideografi
            ->where('paket_jenis', 'platinum')
            ->sum(fn($item) => $item->paket->harga_platinum);
        
        $pemesanansPromo = PemesananPromo::with(['user', 'promo', 'fotografer']);
        $pemesanans = $pemesanansPromo->get();

        // Hitung total harga keseluruhan dari semua pemesanan
        $totalHargaKeseluruhanPromo = $pemesanans->sum(fn($item) => $item->promo->harga ?? 0);

        $totalPendapatanVideografi = $totalHargaSpesialVideografi + $totalHargaPlatinumVideografi ;

        // Total pendapatan keseluruhan
        $totalPendapatanKeseluruhan = $totalPendapatanFotografi + $totalPendapatanVideografi + $totalHargaKeseluruhanPromo;
        $title = "Dashboard";
        return view('home', compact('title','totalPendapatanFotografi', 'totalPendapatanVideografi', 'totalHargaKeseluruhanPromo','totalPendapatanKeseluruhan'));
    }
}
