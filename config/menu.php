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
            ['label' => 'Barang', 'icon' => 'fa fa-cubes-stacked', 'route' => 'barang.index', 'roles' => ['admin','staf','manager']],
            ['label' => 'Kategori', 'icon' => 'fa fa-list', 'route' => 'kategori.index', 'roles' => ['admin','staf','manager']],
            ['label' => 'Merek', 'icon' => 'fa fa-copyright', 'route' => 'merk.index', 'roles' => ['admin','staf','manager']],
            ['label' => 'Lokasi', 'icon' => 'fa fa-school', 'route' => 'lokasi.index', 'roles' => ['admin','staf','manager']],
        ],
    ],

    // [
    //     'header' => 'Pelaporan',
    //     'items' => [
    //         ['label' => 'Pelaporan Masuk', 'icon' => 'fa fa-file-arrow-down', 'route' => 'pelaporan.masuk', 'roles' => ['admin']],
    //         ['label' => 'Tambah Pelaporan', 'icon' => 'fa fa-file-arrow-down', 'route' => 'pelaporan.create', 'roles' => ['staf']],
    //         ['label' => 'Cek Pelaporan', 'icon' => 'fa fa-file-circle-question', 'route' => 'pelaporan.cek', 'roles' => ['staf','manager']],
    //         ['label' => 'Pelaporan Selesai', 'icon' => 'fa fa-file-circle-check', 'route' => 'pelaporan.selesai', 'roles' => ['admin','staf','manager']],
    //     ],
    // ],

    // [
    //     'header' => 'Laporan',
    //     'items' => [
    //         ['label' => 'Laporan Aset', 'icon' => 'fa fa-print', 'route' => 'laporan.inventaris', 'roles' => ['admin','manager']],
    //         ['label' => 'Laporan Perbaikan', 'icon' => 'fa fa-file-pdf', 'route' => 'laporan.perbaikan', 'roles' => ['admin']],
    //     ],
    // ],

];
