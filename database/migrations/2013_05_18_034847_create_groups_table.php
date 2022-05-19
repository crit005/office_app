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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('status')->default('ENABLED');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert some stuff
        DB::table('groups')->insert(
            array(
                [
                    'name' => 'ADMIN',
                    'description' => 'Full permission should no be use',
                    'created_at' =>now(),
                    'updated_at' =>now(),
                ],
                [
                    'name' => 'MANAGER',
                    'description' => 'Top level of tha app user',
                    'created_at' =>now(),
                    'updated_at' =>now(),
                ],
                [
                    'name' => 'OFFICER',
                    'description' => 'User level 2',
                    'created_at' =>now(),
                    'updated_at' =>now(),
                ],
                [
                    'name' => 'ACCOUNT',
                    'description' => 'User level 3',
                    'created_at' =>now(),
                    'updated_at' =>now(),
                ],
                [
                    'name' => 'CUSTOMER SERVICE',
                    'description' => 'User level 4',
                    'created_at' =>now(),
                    'updated_at' =>now(),
                ],
                [
                    'name' => 'MAKETING',
                    'description' => 'Work on maketing page',
                    'created_at' =>now(),
                    'updated_at' =>now(),
                ]
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
};
