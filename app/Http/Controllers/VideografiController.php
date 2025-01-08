<?php

namespace App\Http\Controllers;

use App\Models\Videografi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideografiController extends Controller
{
    public function index()
    {
        $title = "Paket Videografi";
        $videografis = Videografi::all();
        return view('admin.paket.videografi', compact('videografis', 'title'));
    }

    public function create()
    {
        return view('admin.paket.videografi-create'); // Adjusted view name
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'harga_special' => 'nullable|numeric',
            'harga_platinum' => 'nullable|numeric',
            'tenaga_kerja_spesial' => 'nullable|numeric',
            'tenaga_kerja_platinum' => 'nullable|numeric',
            'waktu_spesial' => 'nullable|integer',
            'waktu_platinum' => 'nullable|integer',
            'penyimpanan_special' => 'nullable|string',
            'penyimpanan_platinum' => 'nullable|string',
            'deskripsi_spesial' => 'nullable|string',
            'deskripsi_platinum' => 'nullable|string',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('videografi', 'public');
        }

        Videografi::create([
            'nama' => $request->nama,
            'foto' => $fotoPath,
            'harga_special' => $request->harga_special,
            'harga_platinum' => $request->harga_platinum,
            'tenaga_kerja_spesial' => $request->tenaga_kerja_spesial,
            'tenaga_kerja_platinum' => $request->tenaga_kerja_platinum,
            'waktu_spesial' => $request->waktu_spesial,
            'waktu_platinum' => $request->waktu_platinum,
            'penyimpanan_special' => $request->penyimpanan_special,
            'penyimpanan_platinum' => $request->penyimpanan_platinum,
            'deskripsi_spesial' => $request->deskripsi_spesial,
            'deskripsi_platinum' => $request->deskripsi_platinum,        ]);

        return redirect()->route('videografi.index')->with('success', 'Data Videografi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $videografi = Videografi::findOrFail($id);
        return view('admin.paket.videografi-edit', compact('videografi')); // Adjusted view name
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'harga_special' => 'nullable|numeric',
            'harga_platinum' => 'nullable|numeric',
            'tenaga_kerja_spesial' => 'nullable|numeric',
            'tenaga_kerja_platinum' => 'nullable|numeric',
            'waktu_spesial' => 'nullable|integer',
            'waktu_platinum' => 'nullable|integer',
            'penyimpanan_special' => 'nullable|string',
            'penyimpanan_platinum' => 'nullable|string',
            'deskripsi_spesial' => 'nullable|string',
            'deskripsi_platinum' => 'nullable|string',        ]);

        $videografi = Videografi::findOrFail($id);

        $fotoPath = $videografi->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath && Storage::exists('public/' . $fotoPath)) {
                Storage::delete('public/' . $fotoPath);
            }
            $fotoPath = $request->file('foto')->store('videografi', 'public');
        }

        $videografi->update([
            'nama' => $request->nama,
            'foto' => $fotoPath,
            'harga_special' => $request->harga_special,
            'harga_platinum' => $request->harga_platinum,
            'tenaga_kerja_spesial' => $request->tenaga_kerja_spesial,
            'tenaga_kerja_platinum' => $request->tenaga_kerja_platinum,
            'waktu_spesial' => $request->waktu_spesial,
            'waktu_platinum' => $request->waktu_platinum,
            'penyimpanan_special' => $request->penyimpanan_special,
            'penyimpanan_platinum' => $request->penyimpanan_platinum,
            'deskripsi_spesial' => $request->deskripsi_spesial,
            'deskripsi_platinum' => $request->deskripsi_platinum,        ]);

        return redirect()->route('videografi.index')->with('success', 'Data Videografi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $videografi = Videografi::findOrFail($id);

        if ($videografi->foto && Storage::exists('public/' . $videografi->foto)) {
            Storage::delete('public/' . $videografi->foto);
        }

        $videografi->delete();

        return redirect()->route('videografi.index')->with('success', 'Data Videografi berhasil dihapus');
    }
}
