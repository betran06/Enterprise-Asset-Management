<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
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
    public function store(Request $request)
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

        Karyawan::create([
            'kode_karyawan' => $request->kode_karyawan,
            'nama'          => $request->nama,
            'departement'   => $request->departement,
            'jabatan'       => $request->jabatan,
        ]);

        return redirect('/karyawan')->with('success', 'Data karyawan berhasil ditambahkan');
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
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

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

        return redirect('/karyawan')->with('success', 'Data karyawan berhasil diperbarui');
    }

    /**
     * Hapus karyawan
     * Aset tidak ikut terhapus (karyawan_id jadi NULL)
     */
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->back()->with('success', 'Data karyawan berhasil dihapus');
    }
}