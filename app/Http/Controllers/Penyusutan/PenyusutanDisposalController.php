<?php

namespace App\Http\Controllers\Penyusutan;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use Illuminate\Http\Request;

class PenyusutanDisposalController extends Controller
{
    /**
     * FORM DISPOSAL
     */
    public function create(Aset $aset)
    {
        $setting = $aset->penyusutanSetting;

        if (!$setting) {
            return redirect()
                ->route('penyusutan.show', $aset->id)
                ->with('error', 'Setting penyusutan belum ada.');
        }

        if ($setting->is_disposed) {
            return redirect()
                ->route('penyusutan.show', $aset->id)
                ->with('error', 'Aset sudah didisposal.');
        }

        return view('penyusutan.disposal', compact('aset', 'setting'));
    }

    /**
     * SIMPAN DISPOSAL
     */
    public function store(Request $request, Aset $aset)
    {
        $setting = $aset->penyusutanSetting;

        if (!$setting || $setting->is_disposed) {
            return redirect()->route('penyusutan.show', $aset->id);
        }

        $request->validate([
            'alasan_disposed' => 'required|in:RUSAK,DIJUAL,HIBAH,HILANG,LAINNYA',
            'catatan_disposal' => 'nullable|string|max:500',
        ]);

        $setting->update([
            'is_disposed'     => true,
            'alasan_disposed' => $request->alasan_disposed,
            'catatan_disposal'=> $request->catatan_disposal,
        ]);

        return redirect()
            ->route('penyusutan.show', $aset->id)
            ->with('success', 'Aset berhasil didisposal.');
    }
}
