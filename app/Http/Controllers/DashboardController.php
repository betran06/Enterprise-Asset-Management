<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\LokasiAset;
use App\Models\User;
use App\Models\Pelaporan;

class DashboardController extends Controller
{
    public function index()
    {
        return view('home', [
            'totalAset'        => Aset::count(),
            'totalLokasi'      => LokasiAset::count(),
            'totalAkun'        => User::count(),
            'pelaporanProses'  => Pelaporan::whereIn('status', ['Menunggu', 'Diproses'])->count(),
        ]);
    }
}
