<?php
return [

    // setiap blok = satu header + items
    [
        'header' => 'Dashboard',
        'items' => [
            ['label' => 'Dashboard', 'icon' => 'fa fa-fire', 'route' => 'home', 'roles' => ['admin','staf','manager']],
        ],
    ],

    [
        'header' => 'Akun',
        'items' => [
            ['label' => 'Daftar Akun', 'icon' => 'fa fa-fire', 'route' => 'users.index', 'roles' => ['admin']],
            ['label' => 'Aktivitas Akun', 'icon' => 'fa fa-water', 'route' => 'users.status', 'roles' => ['admin']],
        ],
    ],

    [
        'header' => 'Data Master',
        'items' => [
            ['label' => 'Aset', 'icon' => 'fa fa-cubes-stacked', 'route' => 'aset.index', 'roles' => ['admin','staf','manager']],
            ['label' => 'Kategori', 'icon' => 'fa fa-list', 'route' => 'kategori.index', 'roles' => ['admin','staf','manager']],
            ['label' => 'Lokasi', 'icon' => 'fa fa-school', 'route' => 'lokasi.index', 'roles' => ['admin','staf','manager']],
            ['label' => 'Karyawan', 'icon' => 'fa fa-copyright', 'route' => 'karyawan.index', 'roles' => ['admin','staf','manager']],
        ],
    ],

    [
        'header' => 'Nilai Penyusutan',
        'items' => [
            ['label' => 'Daftar Penyusutan', 'icon'  => 'fa fa-chart-line', 'route' => 'penyusutan.index', 'roles' => ['admin', 'manager']],
            ['label' => 'Setting Penyusutan', 'icon'  => 'fa fa-sliders', 'route' => 'setting.index', 'roles' => ['admin', 'manager']],
        ],
    ],

    [
        'header' => 'Pelaporan',
        'items' => [
            ['label' => 'Pelaporan Aset Masuk', 'icon' => 'fa fa-file-arrow-down', 'route' => 'pelaporan-masuk.index', 'roles' => ['admin','manager']],
            ['label' => 'Tambah Pelaporan Aset', 'icon' => 'fa fa-file-arrow-down', 'route' => 'tambah-pelaporan.index', 'roles' => ['admin','staf']],
            ['label' => 'Cek Pelaporan', 'icon' => 'fa fa-file-circle-question', 'route' => 'cek-pelaporan.index', 'roles' => ['staf','manager','admin']],
            ['label' => 'Pelaporan Aset Selesai', 'icon' => 'fa fa-file-circle-check', 'route' => 'pelaporan-selesai.index', 'roles' => ['admin','staf','manager']],
        ],
    ],

    // [
    //     'header' => 'Laporan',
    //     'items' => [
    //         ['label' => 'Laporan Aset', 'icon' => 'fa fa-print', 'route' => 'laporan.inventaris', 'roles' => ['admin','manager']],
    //         ['label' => 'Laporan Perbaikan', 'icon' => 'fa fa-file-pdf', 'route' => 'laporan.perbaikan', 'roles' => ['admin']],
    //     ],
    // ],

];
