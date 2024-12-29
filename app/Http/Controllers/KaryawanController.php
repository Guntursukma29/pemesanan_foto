<?php 
namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\PemesananPromo;
use App\Models\PemesananVideografi;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    public function pemesananFotografi()
    {
        $user = Auth::user();

        if ($user->role !== 'fotografer') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        $pemesanansFotografi = Pemesanan::where('id_fotografer', $user->id)->get();

        return view('fotografer.fotografi', compact('pemesanansFotografi'));
    }

    public function pemesananVideografi()
    {
        $user = Auth::user();

        if ($user->role !== 'fotografer') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        $pemesanansVideografi = PemesananVideografi::where('id_fotografer', $user->id)->get();

        return view('fotografer.videografi', compact('pemesanansVideografi'));
    }

    public function pemesananPromo()
    {
        $user = Auth::user();

        if ($user->role !== 'fotografer') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        $promo = PemesananPromo::where('id_fotografer', $user->id)->get();

        return view('fotografer.promo', compact('promo'));
    }


    public function updateLinkDokumentasi(Request $request, $id, $tipe)
    {
        // Validasi input
        $request->validate([
            'link_dokumentasi' => 'required|url',
        ]);

        // Tentukan model yang akan diupdate berdasarkan tipe (fotografi, videografi, atau promo)
        if ($tipe == 'fotografi') {
            $pemesanan = Pemesanan::findOrFail($id);
        } elseif ($tipe == 'videografi') {
            $pemesanan = PemesananVideografi::findOrFail($id);
        } elseif ($tipe == 'promo') {
            $pemesanan = PemesananPromo::findOrFail($id);
        } else {
            return redirect()->back()->with('error', 'Tipe pemesanan tidak valid.');
        }

        // Update link dokumentasi dan status pemesanan
        $pemesanan->link_dokumentasi = $request->link_dokumentasi;
        $pemesanan->status_pemesanan = 'dokumentasi';
        $pemesanan->save();

        // Redirect berdasarkan tipe
        if ($tipe == 'fotografi') {
            return redirect()->route('fotografer.fotografi')->with('success', 'Link dokumentasi telah berhasil diperbarui dan status pesanan Menunggu Dokumentasi.');
        } elseif ($tipe == 'videografi') {
            return redirect()->route('fotografer.videografi')->with('success', 'Link dokumentasi telah berhasil diperbarui dan status pesanan Menunggu Dokumentasi.');
        } elseif ($tipe == 'promo') {
            return redirect()->route('fotografer.promo')->with('success', 'Link dokumentasi telah berhasil diperbarui dan status pesanan Menunggu Dokumentasi.');
        }
    }

    public function inputCodeFoto(Request $request, $id, $tipe)
    {
        // Validasi input
        $request->validate([
            'link_foto' => 'required|string|max:255',
        ]);

        if ($tipe == 'fotografi') {
            $pemesanan = Pemesanan::findOrFail($id);
        } elseif ($tipe == 'videografi') {
            $pemesanan = PemesananVideografi::findOrFail($id);
        } elseif ($tipe == 'promo') {
            $pemesanan = PemesananPromo::findOrFail($id);
        } else {
            return redirect()->back()->with('error', 'Tipe pemesanan tidak valid.');
        }

        // Update code_foto dan status pemesanan
        $pemesanan->link_foto = $request->link_foto; 
        $pemesanan->status_pemesanan = 'selesai'; 
        $pemesanan->save();

        // Redirect berdasarkan tipe
        if ($tipe == 'fotografi') {
            return redirect()->route('fotografer.fotografi')->with('success', 'Code foto berhasil diinput dan status pesanan telah diubah menjadi selesai.');
        } elseif ($tipe == 'videografi') {
            return redirect()->route('fotografer.videografi')->with('success', 'Code foto berhasil diinput dan status pesanan telah diubah menjadi selesai.');
        } elseif ($tipe == 'promo') {
            return redirect()->route('fotografer.promo')->with('success', 'Code foto berhasil diinput dan status pesanan telah diubah menjadi selesai.');
        }
    }
    


}
