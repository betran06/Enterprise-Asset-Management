<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->dateTime('occurred_at', 6);

        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('user_name', 100)->nullable();

        // ✅ FIX DI SINI
        $table->string('action', 100);

        $table->string('table_name', 100);
        $table->unsignedBigInteger('row_id')->nullable();
        $table->string('message', 255)->nullable();

        $table->json('before_data')->nullable();
        $table->json('after_data')->nullable();

        $table->string('url', 255)->nullable();
        $table->string('ip_address', 45)->nullable();
        $table->string('http_method', 10)->nullable();

        $table->timestamp('created_at')->useCurrent();

        // indexes
        $table->index(['table_name','row_id'], 'idx_table_row');
        $table->index(['user_id','occurred_at'], 'idx_user_time');
        $table->index(['action','occurred_at'], 'idx_action_time');

        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('audit_logs');
    }
};
