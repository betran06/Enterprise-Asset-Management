<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyusutan_bulanan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('aset_id');
            $table->date('periode'); // store as YYYY-MM-01
            $table->enum('metode', ['GARIS_LURUS', 'SALDO_MENURUN']);
            $table->decimal('beban_bulan', 18, 2);
            $table->decimal('akumulasi_sd_bulan', 18, 2);
            $table->decimal('nilai_buku_akhir', 18, 2);
            $table->unsignedBigInteger('user_id'); // NOT NULL per opsi 1
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamps();

            // indexes
            $table->unique(['aset_id', 'periode']);
            $table->index('aset_id');
            $table->index('periode');
            $table->index(['user_id', 'periode']);

            // foreign keys
            $table->foreign('aset_id')->references('id')->on('aset')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('penyusutan_bulanan', function (Blueprint $table) {
            $table->dropForeign(['aset_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('penyusutan_bulanan');
    }
};
