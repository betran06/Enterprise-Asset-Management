<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback_replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('feedback_reply'); // perbaikan nama kolom
            $table->unsignedBigInteger('feedback_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // indexes
            $table->index('feedback_id');

            // foreign keys
            $table->foreign('feedback_id')->references('id')->on('feedback')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('feedback_replies', function (Blueprint $table) {
            $table->dropForeign(['feedback_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('feedback_replies');
    }
};
