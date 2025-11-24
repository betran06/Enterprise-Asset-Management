<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('roles')->insert([
            ['role' => 'admin',  'created_at' => $now, 'updated_at' => $now],
            ['role' => 'staf',   'created_at' => $now, 'updated_at' => $now],
            ['role' => 'manager','created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
