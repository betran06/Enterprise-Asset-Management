<?php

namespace App\Http\Controllers\Opname;

use App\Http\Controllers\Controller;
use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\Aset;
use App\Models\LokasiAset;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OpnameDetailController extends Controller
{
    /**
     * ===============================
     * FORM INPUT HASIL OPNAME
     * ===============================
     */
    public function create(Opname $opname)
    {
        // Cegah input jika FINAL
        if ($opname->status === 'FINAL') {
            return redirect()
                ->route('opname.show', $opname->id)
                ->with('error', 'Opname sudah difinalisasi.');
        }

        // Dropdown pendukung
        $lokasiAsets = LokasiAset::orderBy('nama_lokasi')->get();
        $karyawans   = Karyawan::orderBy('nama')->get();

        // Data aset yang sudah diinput
        $details = OpnameDetail::with(['aset'])
            ->where('opname_id', $opname->id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('opname.input', compact(
            'opname',
            'lokasiAsets',
            'karyawans',
            'details'
        ));
    }

    /**
     * ===============================
     * AJAX: GET DATA ASET BY QR
     * ===============================
     */
    public function getAsetData(Request $request)
    {
        $kode = $request->query('kode');

        // Default response
        $response = [
            'found'       => false,
            'id'          => null,
            'kode_aset'   => null,
            'nama_aset'   => null,
            'lokasi_id'   => null,
            'lokasi'      => null,
            'karyawan_id' => null,
            'karyawan'    => null,
            'departement' => null,
        ];

        if (! $kode) {
            return response()->json($response);
        }

        $aset = Aset::with(['lokasi', 'karyawan'])
            ->where('kode_aset', $kode)
            ->first();

        if (! $aset) {
            return response()->json($response);
        }

        return response()->json([
            'found'       => true,
            'id'          => $aset->id,
            'kode_aset'   => $aset->kode_aset,
            'nama_aset'   => $aset->nama_aset,
            'lokasi_id'   => $aset->lokasi?->id,
            'lokasi'      => $aset->lokasi?->nama_lokasi,
            'karyawan_id' => $aset->karyawan?->id,
            'karyawan'    => $aset->karyawan?->nama,
            'departement' => $aset->karyawan?->departement,
        ]);
    }

    /**
     * ===============================
     * SIMPAN HASIL OPNAME
     * ===============================
     */
    public function store(Request $request, Opname $opname)
    {
        if ($opname->status === 'FINAL') {
            return redirect()
                ->route('opname.show', $opname->id)
                ->with('error', 'Opname sudah difinalisasi.');
        }

        $request->validate([
            'aset_id'      => 'required|exists:aset,id',
            'status_fisik' => 'required|in:ADA,TIDAK_ADA,RUSAK,HILANG',
            'lokasi_id'    => 'nullable|exists:lokasi_aset,id',
            'karyawan_id'  => 'nullable|exists:karyawan,id',
            'catatan'      => 'nullable|string|max:500',
        ]);

        // Cegah duplikat aset dalam 1 opname
        $exists = OpnameDetail::where('opname_id', $opname->id)
            ->where('aset_id', $request->aset_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Aset ini sudah diinput pada opname ini.');
        }

        OpnameDetail::create([
            'opname_id'    => $opname->id,
            'aset_id'      => $request->aset_id,
            'status_fisik' => $request->status_fisik,
            'lokasi_id'    => $request->lokasi_id,
            'karyawan_id'  => $request->karyawan_id,
            'catatan'      => $request->catatan,
            'user_id'      => Auth::id(),
        ]);

        return redirect()
            ->route('opname.input', $opname->id)
            ->with('success', 'Hasil opname berhasil disimpan.');
    }

    /**
     * ===============================
     * HAPUS DETAIL OPNAME
     * ===============================
     */
    public function destroy(Opname $opname, OpnameDetail $detail)
    {
        if ($opname->status === 'FINAL') {
            return back()->with('error', 'Opname sudah difinalisasi.');
        }

        if ($detail->opname_id !== $opname->id) {
            abort(403);
        }

        $detail->delete();

        return back()->with('success', 'Data opname berhasil dihapus.');
    }

    public function final(Opname $opname)
    {
        // Cegah final ulang
        if ($opname->status === 'FINAL') {
            return back()->with('error', 'Opname sudah difinalisasi.');
        }

        // Pastikan ada minimal 1 aset
        $totalDetail = OpnameDetail::where('opname_id', $opname->id)->count();

        if ($totalDetail === 0) {
            return back()->with('error', 'Tidak bisa finalisasi. Belum ada aset yang diopname.');
        }

        // Update status opname
        $opname->update([
            'status' => 'FINAL',
        ]);

        return redirect()
            ->route('opname.show', $opname->id)
            ->with('success', 'Opname berhasil difinalisasi.');
    }
}
