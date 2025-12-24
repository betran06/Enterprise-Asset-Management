<?php

namespace App\Http\Controllers\Pelaporan;

use App\Models\Feedback;
use App\Models\Pelaporan;
use App\Models\FeedbackReply;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PelaporanMasukController extends Controller
{
    /**
     * Tampilkan daftar pelaporan yang belum selesai.
     */
    public function index()
    {
        // Ambil semua pelaporan yang statusnya bukan "Selesai"
        $pelaporans = Pelaporan::where(function($q) {
            $q->whereNull('status')
              ->orWhere('status', '!=', 'Selesai');
        })->orderBy('id', 'DESC')->get();

        return view('pelaporan-masuk.index', [
            'pelaporans' => $pelaporans,
        ]);
    }

    /**
     * Detail satu pelaporan (untuk admin melihat dan memberi perbaikan).
     */
    public function detail($id)
    {
        $pelaporan = Pelaporan::with(['aset', 'user'])->findOrFail($id);

        // ambil feedback terkait (jika ada)
        $feedback = Feedback::where('pelaporan_id', $pelaporan->id)->first();

        // ambil semua replies untuk feedback tersebut (kalau ada)
        $feedbackReplies = $feedback
            ? FeedbackReply::where('feedback_id', $feedback->id)->orderBy('created_at', 'asc')->get()
            : collect();

        return view('pelaporan-masuk.detail', [
            'pelaporan'       => $pelaporan,
            'feedback'        => $feedback,
            'feedbackReplies' => $feedbackReplies,
        ]);
    }

    /**
     * Tandai pelaporan sebagai "Sedang Diperbaiki".
     */
    public function perbaiki($id)
    {
        $pelaporan = Pelaporan::findOrFail($id);

        $pelaporan->update(['status' => 'Proses Pengecekan']);

        return redirect()->back()->with('success', 'Berhasil mengubah status pelaporan menjadi "Sedang Diperbaiki".');
    }

    /**
     * Tandai pelaporan selesai, dan simpan feedback analisis perbaikan.
     *
     * Menerima request fields:
     *  - analisis_keputusan (recommended)
     *  - analisis_perbaikan (compatibility with previous naming)
     */
    public function selesai(Request $request, $id)
    {
        $pelaporan = Pelaporan::findOrFail($id);

        $validated = $request->validate([
            // accept either field name, but require at least one
            'analisis_keputusan' => ['nullable', 'string', 'max:255'],
            'analisis_perbaikan' => ['nullable', 'string', 'max:255'],
        ]);

        // prefer 'analisis_keputusan' if present, else use 'analisis_perbaikan'
        $analisis = $validated['analisis_keputusan'] ?? $validated['analisis_perbaikan'] ?? null;

        DB::beginTransaction();
        try {
            // update status pelaporan terlebih dulu
            $pelaporan->update(['status' => 'Selesai']);

            // buat atau update feedback terkait pelaporan
            // jika sudah ada feedback sebelumnya, update analisis_keputusan
            $feedback = Feedback::firstOrNew(['pelaporan_id' => $pelaporan->id]);
            $feedback->pelaporan_id = $pelaporan->id;
            $feedback->aset_id = $pelaporan->aset_id;
            // simpan analisis ke kolom yang sesuai migrasi: analisis_keputusan
            if ($analisis) {
                $feedback->analisis_keputusan = $analisis;
            }
            // user_id bisa diisi dari auth jika tersedia (opsional)
            if (auth()->check()) {
                $feedback->user_id = auth()->id();
            }
            $feedback->status = 'Selesai';
            $feedback->save();

            DB::commit();

            return redirect()->back()->with('success', 'Berhasil mengubah status pelaporan menjadi "Selesai".');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyelesaikan pelaporan: ' . $e->getMessage());
        }
    }
}
