<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelaporan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul', 200);
            $table->text('deskripsi');
            $table->enum('status', ['Menunggu','Proses Pengecekan','Selesai'])->nullable();
            $table->unsignedBigInteger('aset_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // indexes
            $table->index('user_id');
            $table->index('aset_id');

            // foreign keys
            $table->foreign('aset_id')->references('id')->on('aset')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('pelaporan', function (Blueprint $table) {
            $table->dropForeign(['aset_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('pelaporan');
    }
};
