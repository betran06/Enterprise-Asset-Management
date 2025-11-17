<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('analisis_keputusan', 255);
            $table->unsignedBigInteger('pelaporan_id');
            $table->enum('status', ['Menunggu','Selesai'])->nullable();
            $table->unsignedBigInteger('aset_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // indexes
            $table->index('pelaporan_id');
            $table->index('aset_id');

            // foreign keys
            $table->foreign('pelaporan_id')->references('id')->on('pelaporan')->onDelete('cascade');
            $table->foreign('aset_id')->references('id')->on('aset')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign(['pelaporan_id']);
            $table->dropForeign(['aset_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('feedback');
    }
};
