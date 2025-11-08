<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // kolom role_id dulu, dibuat nullable agar migrasi tidak gagal pada data lama
            $table->unsignedBigInteger('role_id')->nullable()->after('password');
            $table->index('role_id');

            // tambahkan softDeletes untuk menjaga histori referensi user
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // tambahkan FK dalam langkah terpisah (aman di sebagian DB engine)
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->restrictOnDelete(); // role tidak boleh dihapus jika masih dipakai user
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // drop FK dan index lalu kolom
            $table->dropForeign(['role_id']);
            $table->dropIndex(['role_id']);
            $table->dropColumn('role_id');

            if (Schema::hasColumn('users', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
