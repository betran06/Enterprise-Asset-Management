<?php

namespace App\Http\Controllers;

use App\Models\KategoriAset;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        // Pastikan user terautentikasi; middleware role ditangani di routes
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua kategori, terbaru di atas
        $kategoris = KategoriAset::orderBy('nama_kategori')->get();

        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategori_aset,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max' => 'Panjang nama kategori maksimal 50 karakter.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ]);

        KategoriAset::create($validated);

        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriAset $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriAset $kategori)
    {
        $validated = $request->validate([
            // ignore current id for unique rule
            'nama_kategori' => 'required|string|max:50|unique:kategori_aset,nama_kategori,' . $kategori->id,
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max' => 'Panjang nama kategori maksimal 50 karakter.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriAset $kategori)
    {
        // Jika ada constraint FK, ini akan gagal — tangani dengan try/catch jika perlu
        try {
            $kategori->delete();
            return redirect()->route('kategori.index')
                             ->with('success', 'Kategori berhasil dihapus.');
        } catch (\Throwable $e) {
            // Jika gagal karena FK, beri pesan yang informatif
            return redirect()->route('kategori.index')
                             ->with('error', 'Kategori gagal dihapus. Pastikan tidak ada aset yang menggunakan kategori ini.');
        }
    }
}
