<?php

namespace App\Http\Controllers\Penyusutan;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\DjpKelompok;
use App\Models\AsetPenyusutanSetting;
use Illuminate\Http\Request;

class PenyusutanSettingController extends Controller
{
    /**
     * ===============================
     * DAFTAR ASET + STATUS SETTING
     * ===============================
     */
    public function index()
    {
        $asets = Aset::with('penyusutanSetting')->orderBy('nama_aset')->get();

        return view('setting.index', compact('asets'));
    }

    /**
     * ===============================
     * FORM BUAT SETTING BARU
     * ===============================
     */
    public function create()
    {
        $asets = Aset::doesntHave('penyusutanSetting')
            ->orderBy('nama_aset')
            ->get();

        $djpKelompoks = DjpKelompok::orderBy('nama')->get();

        return view(
            'setting.create',
            compact('asets', 'djpKelompoks')
        );
    }

    /**
     * ===============================
     * SIMPAN SETTING PENYUSUTAN
     * ===============================
     */
    public function store(Request $request)
    {
        $request->validate([
            'aset_id'              => 'required|exists:aset,id|unique:aset_penyusutan_setting,aset_id',
            'djp_kelompok_id'      => 'required|exists:djp_kelompok,id',
            'metode'               => 'required|in:GARIS_LURUS,SALDO_MENURUN',
            'harga_perolehan'      => 'required|numeric|min:0',
            'nilai_sisa'           => 'nullable|numeric|min:0',
            'umur_bulan'           => 'nullable|integer|min:1',
            'tarif_tahunan_override' => 'nullable|numeric|min:0|max:100',
            'tgl_mulai_pakai'      => 'required|date',
        ]);

        AsetPenyusutanSetting::create([
            'aset_id'                 => $request->aset_id,
            'djp_kelompok_id'         => $request->djp_kelompok_id,
            'metode'                  => $request->metode,
            'harga_perolehan'         => $request->harga_perolehan,
            'nilai_sisa'              => $request->nilai_sisa,
            'umur_bulan'              => $request->umur_bulan,
            'tarif_tahunan_override'  => $request->tarif_tahunan_override,
            'tgl_mulai_pakai'         => $request->tgl_mulai_pakai,
        ]);

        return redirect()
            ->route('setting.index')
            ->with('success', 'Setting penyusutan berhasil dibuat.');
    }

    /**
     * ===============================
     * FORM EDIT SETTING
     * ===============================
     */
    public function edit(Aset $aset)
    {
        $setting = $aset->penyusutanSetting;

        if (!$setting) {
            abort(404, 'Setting penyusutan tidak ditemukan.');
        }

        $djpKelompoks = DjpKelompok::orderBy('nama')->get();

        return view(
            'setting.edit',
            compact('aset', 'setting', 'djpKelompoks')
        );
    }

    /**
     * ===============================
     * UPDATE SETTING
     * ===============================
     */
    public function update(Request $request, Aset $aset)
    {
        $setting = $aset->penyusutanSetting;

        if (!$setting) {
            abort(404, 'Setting penyusutan tidak ditemukan.');
        }

        $request->validate([
            'djp_kelompok_id'      => 'required|exists:djp_kelompok,id',
            'metode'               => 'required|in:GARIS_LURUS,SALDO_MENURUN',
            'harga_perolehan'      => 'required|numeric|min:0',
            'nilai_sisa'           => 'nullable|numeric|min:0',
            'umur_bulan'           => 'nullable|integer|min:1',
            'tarif_tahunan_override' => 'nullable|numeric|min:0|max:100',
            'tgl_mulai_pakai'      => 'required|date',
        ]);

        $setting->update([
            'djp_kelompok_id'        => $request->djp_kelompok_id,
            'metode'                 => $request->metode,
            'harga_perolehan'        => $request->harga_perolehan,
            'nilai_sisa'             => $request->nilai_sisa,
            'umur_bulan'             => $request->umur_bulan,
            'tarif_tahunan_override' => $request->tarif_tahunan_override,
            'tgl_mulai_pakai'        => $request->tgl_mulai_pakai,
        ]);

        return redirect()
            ->route('setting.index')
            ->with('success', 'Setting penyusutan berhasil diperbarui.');
    }
}
