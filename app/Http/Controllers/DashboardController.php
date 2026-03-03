<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\LokasiAset;
use App\Models\KategoriAset;
use App\Models\User;
use App\Models\Pelaporan;
use App\Models\AuditLog;
use App\Models\Opname;
use App\Models\AsetPenyusutanSetting;
use App\Models\PenyusutanBulanan;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role->role;

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
        // MANAGER
        // =========================
        $totalPenyusutan = null;
        $pelaporanMasuk  = collect();
        $penyusutanTerakhir  = collect();

        if ($role === 'manager') {

            // aset yang punya setting penyusutan
            $totalPenyusutan = AsetPenyusutanSetting::count();

            $totalOpname = Opname::count();

            // pelaporan masuk (limit 5)
            $pelaporanMasuk = Pelaporan::with('aset')
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get();

            // ==============================
            // Ambil SEMUA aset + penyusutan terakhir masing-masing
            // ==============================
            $penyusutanTerakhir = Aset::with([
                    'penyusutanBulanan' => function ($query) {
                        $query->orderByDesc('periode');
                    }
                ])
                ->whereHas('penyusutanBulanan') // hanya aset yang sudah pernah disusutkan
                ->get();
        }


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

            // manager
            'totalPenyusutan',
            'totalOpname',
            'pelaporanMasuk',
            'penyusutanTerakhir'
        ));
    }
}
