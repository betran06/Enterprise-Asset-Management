<?php

namespace App\Http\Controllers\Penyusutan;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\PenyusutanBulanan;
use App\Models\AsetPenyusutanSetting;
use App\Services\PenyusutanService;
use App\Services\AuditTrailService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PenyusutanController extends Controller
{
    /**
     * Daftar aset + status penyusutan
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
        $aset->load([
            'kategori',
            'lokasi',
            'penyusutanSetting.djpKelompok',
        ]);

        $setting = $aset->penyusutanSetting;

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
        PenyusutanService $penyusutanService,
        AuditTrailService $auditTrailService
    ) {
        // =========================
        // Role check
        // =========================
        if (!auth()->user()->inRoles(['admin', 'manager'])) {
            abort(403, 'Tidak memiliki akses.');
        }

        if (!$aset->penyusutanSetting) {
            return back()->with('error', 'Setting penyusutan belum diisi.');
        }

        try {
            // =========================
            // GENERATE PENYUSUTAN
            // =========================
            $penyusutan = $penyusutanService->generateBulanan(
                $aset,
                $aset->penyusutanSetting,
                auth()->id()
            );

            // =========================
            // AUDIT TRAIL
            // =========================
            $auditTrailService->log(
                action: 'GENERATE_PENYUSUTAN',
                table: 'penyusutan_bulanan',
                rowId: $penyusutan->id,
                message: 'Generate penyusutan aset ' . $aset->kode_aset .
                         ' periode ' . $penyusutan->periode,
                before: null,
                after: $penyusutan->toArray()
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
            'aset'    => $setting->aset,
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
