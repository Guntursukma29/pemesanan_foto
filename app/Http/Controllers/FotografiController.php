<?php

namespace App\Http\Controllers;

use App\Models\Fotografi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotografiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Paket Fotografi";
        $data = Fotografi::all();
        return view('admin.paket.fotografi', compact('data', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Function to show form for creating a new resource (if needed)
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'harga_special' => 'nullable|string|min:0',
            'harga_platinum' => 'nullable|string|min:0',
            'tenaga_kerja_spesial' => 'nullable|string|min:1',
            'tenaga_kerja_platinum' => 'nullable|string|min:1',
            'waktu_spesial' => 'nullable|string|min:1',
            'waktu_platinum' => 'nullable|string|min:1',
            'penyimpanan_special' => 'nullable|string|max:255',
            'penyimpanan_platinum' => 'nullable|string|max:255',
            'deskripsi_spesial' => 'nullable|string',
            'deskripsi_platinum' => 'nullable|string',
        ]);

        // Handle file upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotografi', 'public');
        }

        // Store the data
        Fotografi::create([
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
            'deskripsi_platinum' => $request->deskripsi_platinum,
        ]);

        return redirect()->route('fotografi.index')->with('success', 'Data fotografi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Show specific resource details if needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Function to show form for editing the resource (if needed)
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'harga_special' => 'nullable|string|min:0',
            'harga_platinum' => 'nullable|string|min:0',
            'tenaga_kerja_spesial' => 'nullable|string|min:1',
            'tenaga_kerja_platinum' => 'nullable|string|min:1',
            'waktu_spesial' => 'nullable|string|min:1',
            'waktu_platinum' => 'nullable|string|min:1',
            'penyimpanan_special' => 'nullable|string|max:255',
            'penyimpanan_platinum' => 'nullable|string|max:255',
            'deskripsi_spesial' => 'nullable|string',
            'deskripsi_platinum' => 'nullable|string',        ]);

        // Find the item by ID
        $fotografi = Fotografi::findOrFail($id);

        // Handle photo update
        $fotoPath = $fotografi->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('fotografi', 'public');
        }

        // Update the data
        $fotografi->update([
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

        return redirect()->route('fotografi.index')->with('success', 'Data fotografi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Fotografi::findOrFail($id);

        // Delete photo from storage if exists
        if ($item->foto) {
            Storage::delete('public/' . $item->foto);
        }

        // Delete item from database
        $item->delete();

        return redirect()->route('fotografi.index')->with('success', 'Paket Fotografi berhasil dihapus');
    }
}
