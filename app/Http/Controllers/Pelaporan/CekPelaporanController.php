<?php

namespace App\Http\Controllers\Pelaporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelaporan;
use App\Models\Feedback;
use App\Models\FeedbackReply;

class CekPelaporanController extends Controller
{
    /**
     * List semua pelaporan (untuk user / staf / manager)
     */
    public function index()
    {
        return view('cek-pelaporan.index', [
            'pelaporans' => Pelaporan::orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Detail pelaporan + feedback + reply
     */
    public function detail($id)
    {
        $pelaporan = Pelaporan::findOrFail($id);

        // Ambil feedback pertama (karena secara logika 1 pelaporan = 1 feedback admin)
        $feedback = Feedback::where('pelaporan_id', $pelaporan->id)->first();

        // Ambil reply user jika ada
        $feedbackReply = $feedback
            ? FeedbackReply::where('feedback_id', $feedback->id)->first()
            : null;

        return view('cek-pelaporan.detail', [
            'pelaporan'     => $pelaporan,
            'feedback'      => $feedback,
            'feedbackReply' => $feedbackReply,
        ]);
    }

    /**
     * User mengirim balasan feedback
     */
    public function store(Request $request, Pelaporan $pelaporan)
    {
        $request->validate([
            'feedback_replies' => 'required'
        ]);

        $feedback = $pelaporan->feedbacks()->first();

        if (!$feedback) {
            return back()->with('error', 'Feedback admin belum tersedia.');
        }

        FeedbackReply::create([
            'feedback_id'     => $feedback->id,
            'user_id'         => auth()->id(),
            'feedback_reply'  => $request->feedback_replies,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

}


