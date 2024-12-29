<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PortofolioController extends Controller
{
    // Menampilkan daftar portofolio
    public function index()
    {
        $portofolio = Portofolio::all(); // Mengambil semua data portofolio
        return view('portofolio.index', compact('portofolio'));
    }

    // Menampilkan form untuk menambah portofolio
    public function create()
    {
        return view('portofolio.create');
    }

    // Menyimpan portofolio yang baru
    public function store(Request $request)
    {
        // Validasi foto
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menyimpan file foto
        $fileName = $request->file('foto')->store('portofolio', 'public');

        // Menyimpan data ke tabel portofolio
        Portofolio::create([
            'foto' => $fileName,
        ]);

        return redirect()->route('portofolio.index')->with('success', 'Portofolio berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit portofolio
    public function edit($id)
    {
        $portofolio = Portofolio::findOrFail($id);
        return view('portofolio.edit', compact('portofolio'));
    }

    // Memperbarui portofolio
     public function update(Request $request, $id)
    {
        // Validasi foto
        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menemukan portofolio berdasarkan ID
        $portofolio = Portofolio::findOrFail($id);

        // Jika ada file foto yang di-upload
        if ($request->hasFile('foto')) {
            // Menghapus file lama jika ada
            if ($portofolio->foto) {
                // Menghapus foto yang ada di direktori public/storage
                Storage::disk('public')->delete($portofolio->foto);
            }

            // Menyimpan file foto baru
            $fileName = $request->file('foto')->store('portofolio', 'public');
            $portofolio->foto = $fileName;
        }

        // Menyimpan perubahan ke database
        $portofolio->save();

        // Redirect kembali ke halaman portofolio dengan pesan sukses
        return redirect()->route('portofolio.index')->with('success', 'Portofolio berhasil diperbarui!');
    }

    // Menghapus portofolio
    public function destroy($id)
    {
        $portofolio = Portofolio::findOrFail($id);

        // Menghapus file foto
        if ($portofolio->foto) {
            Storage::disk('public')->delete($portofolio->foto);
        }

        $portofolio->delete();

        return redirect()->route('portofolio.index')->with('success', 'Portofolio berhasil dihapus!');
    }
}

