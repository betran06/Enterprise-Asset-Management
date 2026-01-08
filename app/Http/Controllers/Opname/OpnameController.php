<?php

namespace App\Http\Controllers\Opname;

use App\Http\Controllers\Controller;
use App\Models\Opname;
use App\Models\OpnameDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OpnameController extends Controller
{
    /**
     * ===============================
     * DAFTAR OPNAME
     * ===============================
     */
    public function index()
    {
        $opnames = Opname::with('user')
            ->orderByDesc('tanggal_opname')
            ->get();

        return view('opname.index', compact('opnames'));
    }

    /**
     * ===============================
     * FORM BUAT OPNAME BARU
     * ===============================
     */
    public function create()
    {
        return view('opname.create');
    }

    /**
     * ===============================
     * SIMPAN OPNAME BARU
     * ===============================
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:100',
            'tanggal_opname' => 'required|date',
        ]);

        // generate kode opname
        $tanggal = Carbon::parse($request->tanggal_opname)->format('Ymd');
        $kodeOpname = 'OPN-' . $tanggal . '-' . strtoupper(Str::random(4));

        $opname = Opname::create([
            'kode_opname'    => $kodeOpname,
            'nama'           => $request->nama,
            'tanggal_opname' => $request->tanggal_opname,
            'status'         => 'DRAFT',
            'user_id'        => Auth::id(),
        ]);

        return redirect()
            ->route('opname.show', $opname->id)
            ->with('success', 'Opname berhasil dibuat.');
    }

    /**
     * ===============================
     * DETAIL OPNAME
     * ===============================
     */
    public function show(Opname $opname)
    {
        $opname->load('user');

        $details = $opname->details()
            ->with(['aset', 'lokasi', 'karyawan', 'user'])
            ->orderBy('id')
            ->get();

        return view('opname.show', compact('opname', 'details'));
    }

    /**
     * ===============================
     * FINALISASI OPNAME
     * ===============================
     */
    public function finalisasi(Opname $opname)
    {
        if ($opname->status === 'FINAL') {
            return back()->with('error', 'Opname sudah difinalisasi.');
        }

        if ($opname->details()->count() === 0) {
            return back()->with('error', 'Belum ada data opname aset.');
        }

        $opname->update([
            'status' => 'FINAL',
        ]);

        return redirect()
            ->route('opname.index')
            ->with('success', 'Opname berhasil difinalisasi.');
    }

    public function pdf(Opname $opname)
    {
        if ($opname->status !== 'FINAL') {
            return redirect()
                ->route('opname.show', $opname->id)
                ->with('error', 'Opname belum difinalisasi.');
        }

        $details = OpnameDetail::with([
                'aset.kategori',
                'aset.lokasi',
                'karyawan',
                'user'
            ])
            ->where('opname_id', $opname->id)
            ->orderBy('id')
            ->get();

        // Ringkasan
        $summary = [
            'ADA'        => $details->where('status_fisik', 'ADA')->count(),
            'RUSAK'      => $details->where('status_fisik', 'RUSAK')->count(),
            'TIDAK_ADA'  => $details->where('status_fisik', 'TIDAK_ADA')->count(),
            'HILANG'     => $details->where('status_fisik', 'HILANG')->count(),
            'TOTAL'      => $details->count(),
        ];

        $pdf = Pdf::loadView('opname.pdf', [
            'opname'  => $opname,
            'details' => $details,
            'summary' => $summary,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream(
            'laporan-opname-' . $opname->kode_opname . '.pdf'
        );
    }

}
