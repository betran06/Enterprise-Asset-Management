<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Services\AuditTrailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    /**
     * Tampilkan daftar karyawan
     */
    public function index()
    {
        return view('karyawan.index', [
            'karyawans' => Karyawan::orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Form tambah karyawan
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Simpan data karyawan baru
     */
    public function store(Request $request, AuditTrailService $auditTrailService)
    {
        $validator = Validator::make($request->all(), [
            'kode_karyawan' => 'required|unique:karyawan,kode_karyawan',
            'nama'          => 'required',
            'departement'   => 'nullable',
            'jabatan'       => 'nullable',
        ], [
            'kode_karyawan.required' => 'Kode karyawan wajib diisi',
            'kode_karyawan.unique'   => 'Kode karyawan sudah digunakan',
            'nama.required'          => 'Nama karyawan wajib diisi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $karyawan = Karyawan::create([
            'kode_karyawan' => $request->kode_karyawan,
            'nama'          => $request->nama,
            'departement'   => $request->departement,
            'jabatan'       => $request->jabatan,
        ]);

        // =========================
        // AUDIT TRAIL
        // =========================
        $auditTrailService->log(
            action: 'CREATE_KARYAWAN',
            table: 'karyawan',
            rowId: $karyawan->id,
            message: 'Menambahkan karyawan: ' . $karyawan->nama,
            before: null,
            after: $karyawan->toArray()
        );

        return redirect('/karyawan')
            ->with('success', 'Data karyawan berhasil ditambahkan');
    }

    /**
     * Form edit karyawan
     */
    public function edit($id)
    {
        return view('karyawan.edit', [
            'karyawan' => Karyawan::findOrFail($id)
        ]);
    }

    /**
     * Update data karyawan
     */
    public function update(
        Request $request,
        $id,
        AuditTrailService $auditTrailService
    ) {
        $karyawan = Karyawan::findOrFail($id);
        $before = $karyawan->toArray();

        $validator = Validator::make($request->all(), [
            'kode_karyawan' => 'required|unique:karyawan,kode_karyawan,' . $karyawan->id,
            'nama'          => 'required',
            'departement'   => 'nullable',
            'jabatan'       => 'nullable',
        ], [
            'kode_karyawan.required' => 'Kode karyawan wajib diisi',
            'kode_karyawan.unique'   => 'Kode karyawan sudah digunakan',
            'nama.required'          => 'Nama karyawan wajib diisi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $karyawan->update([
            'kode_karyawan' => $request->kode_karyawan,
            'nama'          => $request->nama,
            'departement'   => $request->departement,
            'jabatan'       => $request->jabatan,
        ]);

        // =========================
        // AUDIT TRAIL
        // =========================
        $auditTrailService->log(
            action: 'UPDATE_KARYAWAN',
            table: 'karyawan',
            rowId: $karyawan->id,
            message: 'Memperbarui karyawan: ' . $karyawan->nama,
            before: $before,
            after: $karyawan->fresh()->toArray()
        );

        return redirect('/karyawan')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    /**
     * Hapus karyawan
     * Aset tidak ikut terhapus (karyawan_id jadi NULL)
     */
    public function destroy($id, AuditTrailService $auditTrailService)
    {
        $karyawan = Karyawan::findOrFail($id);
        $before = $karyawan->toArray();
        $nama = $karyawan->nama;

        $karyawan->delete();

        // =========================
        // AUDIT TRAIL
        // =========================
        $auditTrailService->log(
            action: 'DELETE_KARYAWAN',
            table: 'karyawan',
            rowId: $before['id'],
            message: 'Menghapus karyawan: ' . $nama,
            before: $before,
            after: null
        );

        return redirect()->back()
            ->with('success', 'Data karyawan berhasil dihapus');
    }
}
