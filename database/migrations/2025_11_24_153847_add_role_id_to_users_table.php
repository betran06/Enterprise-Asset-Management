<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Tambah kolom role_id (sementara nullable untuk menghindari error)
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->unsignedBigInteger('role_id')->nullable()->after('password');
                $table->index('role_id');
            }

            // Soft delete (aman kalau belum ada)
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Tambahkan foreign key setelah kolom ada
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->restrictOnDelete(); // mencegah penghapusan role yang sedang dipakai user
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus foreign key
            if (Schema::hasColumn('users', 'role_id')) {
                $table->dropForeign(['role_id']);
                $table->dropIndex(['role_id']);
                $table->dropColumn('role_id');
            }

            // Optional: drop soft delete
            if (Schema::hasColumn('users', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
