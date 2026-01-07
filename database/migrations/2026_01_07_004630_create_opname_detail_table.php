<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opname_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('opname_id');
            $table->unsignedBigInteger('aset_id');
            $table->enum('status_fisik', ['ADA','TIDAK_ADA','RUSAK','HILANG']);
            $table->unsignedBigInteger('lokasi_id')->nullable();
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // unique
            $table->unique(['opname_id', 'aset_id']);

            // indexes
            $table->index('opname_id');
            $table->index('aset_id');
            $table->index('lokasi_id');
            $table->index('karyawan_id');
            $table->index('user_id');

            // foreign keys
            $table->foreign('opname_id')->references('id')->on('opname')->onDelete('cascade');
            $table->foreign('aset_id')->references('id')->on('aset')->onDelete('restrict');
            $table->foreign('lokasi_id')->references('id')->on('lokasi_aset')->onDelete('set null');
            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('opname_detail', function (Blueprint $table) {
            $table->dropForeign(['opname_id']);
            $table->dropForeign(['aset_id']);
            $table->dropForeign(['lokasi_id']);
            $table->dropForeign(['karyawan_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('opname_detail');
    }
};
