<?php

namespace App\Http\Controllers\Pelaporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelaporan;
use App\Models\Feedback;
use App\Models\FeedbackReply;
use App\Services\AuditTrailService;
use Barryvdh\DomPDF\Facade\Pdf;

class PelaporanSelesaiController extends Controller
{
    /**
     * List pelaporan yang sudah selesai
     */
    public function index()
    {
        return view('pelaporan-selesai.index', [
            'pelaporans' => Pelaporan::with(['aset'])
                ->where('status', 'Selesai')
                ->orderBy('updated_at', 'DESC')
                ->get()
        ]);
    }

    /**
     * Cetak laporan pelaporan selesai (PDF)
     */
    public function cetakLaporan(
        $id,
        AuditTrailService $auditTrailService
    ) {
        $pelaporan = Pelaporan::with(['aset'])->findOrFail($id);

        // feedback (1 pelaporan -> bisa ada / tidak)
        $feedback = Feedback::where('pelaporan_id', $pelaporan->id)->first();

        // reply user (opsional)
        $feedbackReply = $feedback
            ? FeedbackReply::where('feedback_id', $feedback->id)->first()
            : null;

        // =========================
        // AUDIT TRAIL
        // =========================
        $auditTrailService->log(
            action: 'EXPORT_PELAPORAN_SELESAI_PDF',
            table: 'pelaporan',
            rowId: $pelaporan->id,
            message: 'Mencetak laporan pelaporan selesai (PDF)',
            before: null,
            after: [
                'pelaporan_id' => $pelaporan->id,
                'status'       => $pelaporan->status,
            ]
        );

        $pdf = Pdf::loadView('pelaporan-selesai.cetak-laporan', [
            'pelaporan'     => $pelaporan,
            'feedback'      => $feedback,
            'feedbackReply' => $feedbackReply,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-pelaporan-' . $pelaporan->id . '.pdf');
    }
}
