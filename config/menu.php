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
        'header' => 'Data Master',
        'items' => [
            ['label' => 'Aset', 'icon' => 'fa fa-cubes-stacked', 'route' => 'aset.index', 'roles' => ['admin','staf','manager']],
            ['label' => 'Kategori', 'icon' => 'fa fa-list', 'route' => 'kategori.index', 'roles' => ['admin','staf','manager']],
            // ['label' => 'Merek', 'icon' => 'fa fa-copyright', 'route' => 'merk.index', 'roles' => ['admin','staf','manager']],
            ['label' => 'Lokasi', 'icon' => 'fa fa-school', 'route' => 'lokasi.index', 'roles' => ['admin','staf','manager']],
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
