<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opname', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_opname', 30)->unique();
            $table->string('nama', 100);
            $table->date('tanggal_opname');
            $table->enum('status', ['DRAFT', 'FINAL'])->default('DRAFT');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // indexes
            $table->index('user_id');
            $table->index('tanggal_opname');

            // foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('opname', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('opname');
    }
};
