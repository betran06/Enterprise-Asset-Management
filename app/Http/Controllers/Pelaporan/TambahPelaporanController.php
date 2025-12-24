<?php

namespace App\Http\Controllers\Pelaporan;

use App\Models\Aset;
use App\Models\Pelaporan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class TambahPelaporanController extends Controller
{
    /**
     * Tampilkan form tambah pelaporan.
     */
    public function index()
    {
        return view('tambah-pelaporan.index');
    }

    /**
     * Ambil data aset berdasarkan QR Code (param "result").
     * Mengembalikan JSON:
     * id, nama_aset, kategori, merek, lokasi
     */
    public function getDataAset(Request $request)
    {
        $qrCode = $request->input('result');

        // Default jika aset tidak ditemukan
        $response = [
            'id' => null,
            'nama_aset' => null,
            'kategori' => null,
            'merek' => null,
            'lokasi' => null,
        ];

        if (! $qrCode) {
            return response()->json($response);
        }

        $aset = Aset::with(['kategori', 'lokasi'])
            ->where('kode_aset', $qrCode)
            ->first();

        if ($aset) {
            $response = [
                'id' => $aset->id,
                'nama_aset' => $aset->nama_aset,
                'kategori' => optional($aset->kategori)->nama_kategori,
                'merek' => $aset->merek,
                'lokasi' => optional($aset->lokasi)->nama_lokasi,
            ];
        }

        return response()->json($response);
    }

    /**
     * Simpan pelaporan baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul'     => 'required|string|max:200',
            'deskripsi' => 'required|string',
            'aset_id'   => 'required|exists:aset,id',
        ], [
            'judul.required' => 'Judul pelaporan wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'aset_id.required' => 'Aset belum dipilih atau QR tidak valid.',
            'aset_id.exists' => 'Aset tidak ditemukan.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Pelaporan::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'aset_id'   => $request->aset_id,
            'user_id'   => Auth::id(),
            'status'    => 'Menunggu',
        ]);

        return redirect()
            ->route('tambah-pelaporan.index')
            ->with('success', 'Berhasil menambahkan pelaporan baru.');
    }
}
