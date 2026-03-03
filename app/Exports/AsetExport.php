<?php

namespace App\Exports;

use App\Models\Aset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AsetExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Aset::with(['kategori', 'lokasi', 'karyawan'])
            ->orderBy('kode_aset')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Aset',
            'Nama Aset',
            'Merek',
            'Deskripsi',
            'Tanggal Penambahan',
            'Kategori',
            'Lokasi',
            'Pengguna',
            'Dibuat Pada',
        ];
    }

    public function map($aset): array
    {
        return [
            $aset->kode_aset,
            $aset->nama_aset,
            $aset->merek ?? '-',
            $aset->deskripsi ?? '-',
            $aset->tgl_penambahan,
            $aset->kategori->nama_kategori ?? '-',
            $aset->lokasi->nama_lokasi ?? '-',
            $aset->karyawan->nama ?? '-',
            $aset->created_at,
        ];
    }
}