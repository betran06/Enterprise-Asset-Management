<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset_penyusutan_setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('aset_id')->unique();
            $table->Integer('djp_kelompok_id');
            $table->enum('metode', ['GARIS_LURUS', 'SALDO_MENURUN'])->default('GARIS_LURUS');
            $table->decimal('harga_perolehan', 18, 2)->default(0);
            $table->decimal('nilai_sisa', 18, 2)->nullable();
            $table->integer('umur_bulan')->nullable();
            // $table->decimal('tarif_tahunan_override', 5, 2)->nullable();
            $table->boolean('is_disposed')->default(false);
            $table->date('tgl_mulai_pakai');
            $table->enum('alasan_disposed', ['RUSAK','DIJUAL','HIBAH','HILANG','LAINNYA'])->nullable();
            $table->text('catatan_disposal')->nullable();
            $table->timestamps();

            // indexes
            $table->index('djp_kelompok_id');
            $table->index('tgl_mulai_pakai');

            // foreign keys
            $table->foreign('aset_id')->references('id')->on('aset')->onDelete('cascade');
            $table->foreign('djp_kelompok_id')->references('id')->on('djp_kelompok')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('aset_penyusutan_setting', function (Blueprint $table) {
            $table->dropForeign(['aset_id']);
            $table->dropForeign(['djp_kelompok_id']);
        });
        Schema::dropIfExists('aset_penyusutan_setting');
    }
};
