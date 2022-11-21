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
        Schema::table('depatments', function (Blueprint $table) {
            $table->string('bg_color')->after('position')->default('#FFFFFF');
            $table->string('text_color')->after('position')->default('#000000');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('depatments', function (Blueprint $table) {
            $table->dropColumn(['bg_color','text_color']);
        });
    }
};
