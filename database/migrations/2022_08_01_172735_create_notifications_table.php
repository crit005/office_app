<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('message');
            $table->longText('description')->nullable();
            $table->string('page')->nullable();
            $table->string('type');
            $table->string('file_name')->nullable();
            $table->string('download_link')->nullable();
            $table->foreignUuid('batch_id')->nullable()->job_batches('id')->on('job_batches')->cascadeOnDelete();
            $table->string('status');
            $table->timestamps();
            // $table->index(['account_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
