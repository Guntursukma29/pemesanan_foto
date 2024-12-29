<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Promo;
use App\Models\Ulasan;
use App\Models\Fotografi;
use App\Models\Portofolio;
use App\Models\Videografi;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $user = User::all();
        $data = Fotografi::all();
        $videografis = Videografi::all();
        $portofolio = Portofolio::all();
        $ulasan = Ulasan::with([
            'pemesanan.fotografi',
            'pemesananVideografi.videografi',
            'pemesananPromo.promo'
        ])->where('status', 'tampilkan')->get();
        return view('landingpage', compact('data', 'videografis','ulasan','user', 'portofolio'));  // Ganti dengan view yang sesuai untuk halaman customer
    }
    public function showFotografi($id)
    {
        $fotografi = Fotografi::findOrFail($id);
        $averageRating = Ulasan::where('pemesanan_id', $id)->avg('bintang');
        return view('detail-fotografi', compact('fotografi','averageRating'));
    }

    public function showVideografi($id)
    {
        $videografi = Videografi::findOrFail($id);
        $averageRating = Ulasan::where('pemesanan_videografi_id', $id)->avg('bintang');
        return view('detail-videografi', compact('videografi','averageRating'));
    }
    public function promo()
    {
        $data = Promo::all(); // Mengambil semua data promo
        return view('promo', compact('data'));
    }
    public function show($id)
    {
        // Ambil data promo berdasarkan ID
        $promo = Promo::findOrFail($id);
        $averageRating = Ulasan::where('pemesanan_promo_id', $id)->avg('bintang');
        // Tampilkan view dengan data promo
        return view('detail_promo', compact('promo','averageRating'));
    }

}

