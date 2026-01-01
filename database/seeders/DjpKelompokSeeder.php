<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DjpKelompokSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('djp_kelompok')->insert([
            [
                'id' => 1,
                'nama' => 'Kelompok 1',
                'masa_manfaat_tahun' => 4,
                'tarif_gl_percent' => 25.00,
                'tarif_sm_percent' => 50.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'nama' => 'Kelompok 2',
                'masa_manfaat_tahun' => 8,
                'tarif_gl_percent' => 12.50,
                'tarif_sm_percent' => 25.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'nama' => 'Kelompok 3',
                'masa_manfaat_tahun' => 16,
                'tarif_gl_percent' => 6.25,
                'tarif_sm_percent' => 12.50,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'nama' => 'Kelompok 4',
                'masa_manfaat_tahun' => 20,
                'tarif_gl_percent' => 5.00,
                'tarif_sm_percent' => 10.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
