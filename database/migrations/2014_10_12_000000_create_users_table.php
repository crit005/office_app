<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('group_id')->nullable()->references('id')->on('groups')->nullOnDelete();
            $table->string('status')->default('ACTIVE');
            $table->string('photo')->nullable();
            $table->mediumText('description')->nullable();
            $table->json('personall')->nullable()->default(null);
            $table->integer('created_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array([
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@office.com',
                'password' => '$2y$10$wv6Y63YFIw7VYaMyAS0yZ.W49a5eVTjXSRzfJUu7tz5cdQGUN8yj.',
                'group_id' => 1,
                'status' => 'ACTIVE',
                'description' => 'First user',
                'created_at' => now(),
                'updated_at' => now(),
            ])
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
