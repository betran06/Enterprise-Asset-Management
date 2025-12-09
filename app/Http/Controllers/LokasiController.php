<?php

namespace App\Http\Controllers;

use App\Models\LokasiAset;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasis = LokasiAset::orderBy('nama_lokasi')->get();
        return view('lokasi.index', compact('lokasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:50|unique:lokasi_aset,nama_lokasi',
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'nama_lokasi.max' => 'Panjang nama lokasi maksimal 50 karakter.',
            'nama_lokasi.unique' => 'Nama lokasi sudah ada.',
        ]);

        LokasiAset::create($validated);

        return redirect()->route('lokasi.index')
                         ->with('success', 'Lokasi berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LokasiAset $lokasi)
    {
        return view('lokasi.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LokasiAset $lokasi)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:50|unique:lokasi_aset,nama_lokasi,' . $lokasi->id,
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'nama_lokasi.max' => 'Panjang nama lokasi maksimal 50 karakter.',
            'nama_lokasi.unique' => 'Nama lokasi sudah ada.',
        ]);

        $lokasi->update($validated);

        return redirect()->route('lokasi.index')
                         ->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LokasiAset $lokasi)
    {
        try {
            $lokasi->delete();
            return redirect()->route('lokasi.index')
                             ->with('success', 'Lokasi berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->route('lokasi.index')
                             ->with('error', 'Lokasi gagal dihapus. Pastikan tidak ada aset yang terhubung ke lokasi ini.');
        }
    }
}
