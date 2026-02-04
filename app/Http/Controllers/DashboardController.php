<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\LokasiAset;
use App\Models\KategoriAset;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Pelaporan;
use App\Models\AuditLog;
use App\Models\Opname;
use App\Models\AsetPenyusutanSetting;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // DATA UMUM (SEMUA ROLE)
        // =========================
        $totalAset     = Aset::count();
        $totalLokasi   = LokasiAset::count();
        $totalKategori = KategoriAset::count();

        // =========================
        // ADMIN
        // =========================
        $totalAkun = User::count();

        $auditLogs = AuditLog::orderByDesc('occurred_at')
            ->limit(5)
            ->get();

        $usersStatus = User::with('role')
            ->orderBy('name')
            ->take(4)
            ->get()
            ->map(function ($user) {
                $user->is_online = Cache::has('user-is-online-' . $user->id);
                return $user;
            });

        $pelaporanMasuk = Pelaporan::whereIn('status', [
            'Menunggu',
            'Diproses',
            'Proses Pengecekan'
        ])->count();

        // =========================
        // STAF
        // =========================
        $pelaporanStaf = Pelaporan::with(['aset.lokasi'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $totalOpname = Opname::count();

        // =========================
        // MANAJER
        // =========================
        $totalKaryawan = Karyawan::count();

        $penyusutanAset = Aset::with('penyusutanSetting')
            ->whereHas('penyusutanSetting', function ($q) {
                $q->where('is_disposed', false);
            })
            ->limit(5)
            ->get();

        return view('home', compact(
            // umum
            'totalAset',
            'totalLokasi',
            'totalKategori',

            // admin
            'totalAkun',
            'auditLogs',
            'usersStatus',
            'pelaporanMasuk',

            // staf
            'pelaporanStaf',
            'totalOpname',

            // manajer
            'totalKaryawan',
            'penyusutanAset'
        ));
    }
}
