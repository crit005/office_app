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
        Schema::create('cashdrawers', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->double("balance")->default(0);
            $table->date("group");
            $table->foreignId("owner")->nullable()->references("id")->on("users")->nullOnDelete();
            $table->longText("description")->nullable();
            $table->enum("status",["OPEN", "CLOSED"])->default("OPEN");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashdrawers');
    }
};
