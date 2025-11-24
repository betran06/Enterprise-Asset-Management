<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // pastikan role 'admin' sudah ada
        $role = DB::table('roles')->where('role', 'admin')->first();

        if (!$role) {
            $this->command->error("Role 'admin' belum ditemukan. Jalankan RoleSeeder dulu.");
            return;
        }

        // buat user admin (ubah data sesuai kebutuhan)
        $userId = DB::table('users')->insertGetId([
            'name' => 'Admin Sistem',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // ganti kalau perlu
            'role_id' => $role->id,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->command->info("User admin dibuat dengan id: {$userId} (email: admin@example.com / password: password)");
    
    }
}
