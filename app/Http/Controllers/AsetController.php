<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\KategoriAset;
use App\Models\LokasiAset;
use App\Models\Karyawan;
use App\Models\Pelaporan;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\AuditTrailService;

class AsetController extends Controller
{
    public function index()
    {
        $asets = Aset::with(['kategori', 'lokasi', 'karyawan'])
            ->orderBy('id', 'desc')
            ->get();

        return view('aset.index', compact('asets'));
    }

    public function create()
    {
        $kategoris = KategoriAset::orderBy('nama_kategori')->get();
        $lokasis = LokasiAset::orderBy('nama_lokasi')->get();
        $karyawans = Karyawan::orderBy('nama')->get();

        return view('aset.create', compact('kategoris', 'lokasis', 'karyawans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_aset'      => 'required|string|max:35|unique:aset,kode_aset',
            'nama_aset'      => 'required|string|max:150',
            'merek'          => 'nullable|string|max:100',
            'deskripsi'      => 'nullable|string',
            'tgl_penambahan' => 'required|date',
            'kategori_id'    => 'required|exists:kategori_aset,id',
            'lokasi_id'      => 'required|exists:lokasi_aset,id',
            'karyawan_id'    => 'nullable|exists:karyawan,id',
            'gambar'         => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ]);

        DB::beginTransaction();
        $gambarPath = null;
        $qrPath = null;

        try {
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $fileName = uniqid('aset_') . '.' . $file->getClientOriginalExtension();
                $gambarPath = $file->storeAs('gambar', $fileName, 'public');
            }

            $aset = Aset::create([
                'kode_aset'      => $validated['kode_aset'],
                'gambar'         => $gambarPath,
                'nama_aset'      => $validated['nama_aset'],
                'merek'          => $validated['merek'] ?? null,
                'deskripsi'      => $validated['deskripsi'] ?? null,
                'tgl_penambahan' => $validated['tgl_penambahan'],
                'kategori_id'    => $validated['kategori_id'],
                'lokasi_id'      => $validated['lokasi_id'],
                'karyawan_id'    => $validated['karyawan_id'] ?? null,
            ]);

            // AUDIT CREATE
            AuditTrailService::log(
                'CREATE',
                'aset',
                $aset->id,
                'Menambahkan aset baru',
                null,
                $aset->toArray()
            );

            $kode = $aset->kode_aset;
            $qrPath = 'qrcode/' . $kode . '.png';

            $writer = new PngWriter();
            $qrCode = new QrCode($kode);
            $qrImage = $writer->write($qrCode);
            Storage::disk('public')->put($qrPath, $qrImage->getString());

            DB::commit();

            return redirect()->route('aset.index')->with('success', 'Aset berhasil dibuat.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if ($gambarPath && Storage::disk('public')->exists($gambarPath)) {
                Storage::disk('public')->delete($gambarPath);
            }
            if ($qrPath && Storage::disk('public')->exists($qrPath)) {
                Storage::disk('public')->delete($qrPath);
            }

            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan aset.');
        }
    }

    public function show(Aset $aset)
    {
        $pelaporans = Pelaporan::with([
                'user',
                'feedbacks.user',
                'feedbacks.replies.user'
            ])
            ->where('aset_id', $aset->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $karyawans = Karyawan::orderBy('nama')->get();

        $qrPath = 'qrcode/' . $aset->kode_aset . '.png';
        $qrUrl = Storage::disk('public')->exists($qrPath)
            ? Storage::url($qrPath)
            : null;

        return view('aset.show', compact('aset', 'pelaporans', 'karyawans', 'qrUrl'));
    }

    public function edit(Aset $aset)
    {
        $kategoris = KategoriAset::orderBy('nama_kategori')->get();
        $lokasis = LokasiAset::orderBy('nama_lokasi')->get();
        $karyawans = Karyawan::orderBy('nama')->get();

        return view('aset.edit', compact('aset', 'kategoris', 'lokasis', 'karyawans'));
    }

    public function update(Request $request, Aset $aset)
    {
        $validated = $request->validate([
            'kode_aset'      => 'required|string|max:35|unique:aset,kode_aset,' . $aset->id,
            'nama_aset'      => 'required|string|max:150',
            'merek'          => 'nullable|string|max:100',
            'deskripsi'      => 'nullable|string',
            'tgl_penambahan' => 'required|date',
            'kategori_id'    => 'required|exists:kategori_aset,id',
            'lokasi_id'      => 'required|exists:lokasi_aset,id',
            'karyawan_id'    => 'nullable|exists:karyawan,id',
            'gambar'         => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ]);

        DB::beginTransaction();
        $newGambarPath = null;
        $qrPath = null;

        try {
            $before = $aset->toArray();

            $newGambarPath = $aset->gambar;
            if ($request->hasFile('gambar')) {
                if ($aset->gambar && Storage::disk('public')->exists($aset->gambar)) {
                    Storage::disk('public')->delete($aset->gambar);
                }
                $file = $request->file('gambar');
                $fileName = uniqid('aset_') . '.' . $file->getClientOriginalExtension();
                $newGambarPath = $file->storeAs('gambar', $fileName, 'public');
            }

            $oldKode = $aset->kode_aset;
            $newKode = $validated['kode_aset'];

            $aset->update([
                'kode_aset'      => $newKode,
                'gambar'         => $newGambarPath,
                'nama_aset'      => $validated['nama_aset'],
                'merek'          => $validated['merek'] ?? null,
                'deskripsi'      => $validated['deskripsi'] ?? null,
                'tgl_penambahan' => $validated['tgl_penambahan'],
                'kategori_id'    => $validated['kategori_id'],
                'lokasi_id'      => $validated['lokasi_id'],
                'karyawan_id'    => $validated['karyawan_id'] ?? null,
            ]);

            // AUDIT UPDATE
            AuditTrailService::log(
                'UPDATE',
                'aset',
                $aset->id,
                'Mengubah data aset',
                $before,
                $aset->fresh()->toArray()
            );

            if ($oldKode !== $newKode) {
                $oldQrPath = 'qrcode/' . $oldKode . '.png';
                if (Storage::disk('public')->exists($oldQrPath)) {
                    Storage::disk('public')->delete($oldQrPath);
                }

                $qrPath = 'qrcode/' . $newKode . '.png';
                $writer = new PngWriter();
                $qrCode = new QrCode($newKode);
                $qrImage = $writer->write($qrCode);
                Storage::disk('public')->put($qrPath, $qrImage->getString());
            }

            DB::commit();

            return redirect()->route('aset.index')->with('success', 'Aset berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if ($newGambarPath && $newGambarPath !== $aset->gambar && Storage::disk('public')->exists($newGambarPath)) {
                Storage::disk('public')->delete($newGambarPath);
            }
            if ($qrPath && Storage::disk('public')->exists($qrPath)) {
                Storage::disk('public')->delete($qrPath);
            }

            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui aset.');
        }
    }

    public function destroy(Aset $aset)
    {
        try {
            $before = $aset->toArray();

            if ($aset->gambar && Storage::disk('public')->exists($aset->gambar)) {
                Storage::disk('public')->delete($aset->gambar);
            }

            $qrPath = 'qrcode/' . $aset->kode_aset . '.png';
            if (Storage::disk('public')->exists($qrPath)) {
                Storage::disk('public')->delete($qrPath);
            }

            $aset->delete();

            // AUDIT DELETE
            AuditTrailService::log(
                'DELETE',
                'aset',
                $aset->id,
                'Menghapus aset',
                $before,
                null
            );

            return redirect()->route('aset.index')->with('success', 'Aset berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->route('aset.index')->with('error', 'Gagal menghapus aset.');
        }
    }

    public function updatePengguna(Request $request, Aset $aset)
    {
        $request->validate([
            'karyawan_id' => 'nullable|exists:karyawan,id',
        ]);

        $before = $aset->toArray();

        $aset->update([
            'karyawan_id' => $request->karyawan_id,
        ]);

        // AUDIT UPDATE PENGGUNA
        AuditTrailService::log(
            'UPDATE',
            'aset',
            $aset->id,
            'Mengubah pengguna aset',
            $before,
            $aset->fresh()->toArray()
        );

        return back()->with('success', 'Pengguna aset berhasil diperbarui.');
    }

    //cetak pdf
    public function exportPdf()
    {
        $asets = Aset::orderBy('kode_aset')->get();

        $pdf = Pdf::loadView('aset.pdf', [
            'asets' => $asets,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('daftar-aset.pdf');
    }
}
