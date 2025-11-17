<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_aset', 35)->unique();
            $table->string('gambar', 255)->nullable();
            $table->string('nama_aset', 150);
            $table->string('merek', 100)->nullable();
            $table->text('deskripsi')->nullable();
            $table->date('tgl_penambahan');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('lokasi_id');
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->timestamps();

            // indexes
            $table->index('kategori_id');
            $table->index('lokasi_id');
            $table->index('karyawan_id');

            // foreign keys
            $table->foreign('kategori_id')->references('id')->on('kategori_aset')->restrictOnDelete();
            $table->foreign('lokasi_id')->references('id')->on('lokasi_aset')->restrictOnDelete();
            $table->foreign('karyawan_id')->references('id')->on('karyawan')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('aset', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['lokasi_id']);
            $table->dropForeign(['karyawan_id']);
        });

        Schema::dropIfExists('aset');
    }
};
