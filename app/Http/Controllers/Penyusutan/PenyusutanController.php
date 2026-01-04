<?php

namespace App\Http\Controllers\Penyusutan;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\PenyusutanBulanan;
use App\Models\AsetPenyusutanSetting;
use App\Services\PenyusutanService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class PenyusutanController extends Controller
{
    /**
     * Daftar aset + status penyusutan
     * Admin & Manager & Staf (lihat saja)
     */
    public function index()
    {
        $asets = Aset::with([
            'penyusutanSetting',
            'penyusutanBulanan' => function ($q) {
                $q->latest('periode');
            }
        ])->get();

        return view('penyusutan.index', compact('asets'));
    }

    /**
     * Detail penyusutan per aset
     */
    public function show(Aset $aset)
    {
        // eager load relasi
        $aset->load([
            'kategori',
            'lokasi',
            'penyusutanSetting.djpKelompok',
        ]);

        // setting (boleh NULL)
        $setting = $aset->penyusutanSetting;

        // riwayat penyusutan
        $riwayat = PenyusutanBulanan::where('aset_id', $aset->id)
            ->orderBy('periode', 'asc')
            ->get();

        return view('penyusutan.show', compact(
            'aset',
            'setting',
            'riwayat'
        ));
    }


    /**
     * Generate penyusutan bulanan (manual)
     * HANYA admin & manager
     */
    public function susutkan(
        Aset $aset,
        PenyusutanService $penyusutanService
    ) {
        // =========================
        // Role check (double safety)
        // =========================
        if (!auth()->user()->inRoles(['admin', 'manager'])) {
            abort(403, 'Tidak memiliki akses.');
        }

        // Pastikan setting sudah ada
        if (!$aset->penyusutanSetting) {
            return back()->with('error', 'Setting penyusutan belum diisi.');
        }

        try {
            $penyusutanService->generateBulanan(
                $aset,
                $aset->penyusutanSetting,
                auth()->id()
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Penyusutan bulan ini berhasil dibuat.');
    }


    public function cetakPdf($asetId)
    {
        $setting = AsetPenyusutanSetting::with(['aset.kategori', 'aset.lokasi', 'djpKelompok'])
            ->where('aset_id', $asetId)
            ->firstOrFail();

        $riwayat = PenyusutanBulanan::where('aset_id', $asetId)
            ->orderBy('periode')
            ->get();

        $data = [
            'aset' => $setting->aset,
            'setting' => $setting,
            'riwayat' => $riwayat,
        ];

        $pdf = Pdf::loadView('penyusutan.pdf', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream(
            'laporan-penyusutan-' . $setting->aset->kode_aset . '.pdf'
        );
    }

}
