<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokasi_aset', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_lokasi', 50);
            $table->timestamps();

            $table->unique('nama_lokasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi_aset');
    }
};
