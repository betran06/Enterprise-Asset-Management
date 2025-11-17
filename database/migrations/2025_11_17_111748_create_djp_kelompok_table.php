<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('djp_kelompok', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('nama', 50);
            $table->integer('masa_manfaat_tahun');
            $table->decimal('tarif_gl_percent', 5, 2);
            $table->decimal('tarif_sm_percent', 5, 2);
            $table->timestamps();

            $table->index('nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('djp_kelompok');
    }
};
