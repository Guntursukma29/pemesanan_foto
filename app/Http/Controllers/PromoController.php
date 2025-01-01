<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;

class PromoController extends Controller
{
    public function index()
    {
        $promo = Promo::all();
        return view('admin.promo.index', compact('promo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'foto' => 'required|image',
            'tipe' => 'required',
            'harga' => 'required|numeric',
            'waktu' => 'required',
            'tenaga_kerja' => 'required',
            'penyimpanan' => 'required',
            'deskripsi' => 'required',
            'mulai' => 'required|date|before_or_equal:berakhir',
            'berakhir' => 'required|date|after_or_equal:mulai',
        ]);

        $fotoPath = $request->file('foto')->store('promo', 'public');

        Promo::create([
            'nama' => $request->nama,
            'foto' => $fotoPath,
            'tipe' => $request->tipe,
            'harga' => $request->harga,
            'waktu' => $request->waktu,
            'tenaga_kerja' => $request->tenaga_kerja,
            'penyimpanan' => $request->penyimpanan,
            'deskripsi' => $request->deskripsi,
            'mulai' => $request->mulai,
            'berakhir' => $request->berakhir,
        ]);

        return redirect()->back()->with('success', 'Promo berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'foto' => 'nullable|image',
            'tipe' => 'required',
            'harga' => 'required|numeric',
            'waktu' => 'required',
            'tenaga_kerja' => 'required',
            'penyimpanan' => 'required',
            'deskripsi' => 'required',
            'mulai' => 'required|date|before_or_equal:berakhir',
            'berakhir' => 'required|date|after_or_equal:mulai',
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('promo', 'public');
            $promo->foto = $fotoPath;
        }

        $promo->update([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'harga' => $request->harga,
            'waktu' => $request->waktu,
            'tenaga_kerja' => $request->tenaga_kerja,
            'penyimpanan' => $request->penyimpanan,
            'deskripsi' => $request->deskripsi,
            'mulai' => $request->mulai,
            'berakhir' => $request->berakhir,
        ]);

        return redirect()->back()->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->back()->with('success', 'Promo berhasil dihapus.');
    }
}
