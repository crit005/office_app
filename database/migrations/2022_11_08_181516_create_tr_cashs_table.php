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
        Schema::create('tr_cashes', function (Blueprint $table) {
            $table->id();
            $table->date('tr_date');
            $table->foreignId('item_id')->nullable()->references('id')->on('items')->nullOnDelete();
            $table->string('other_name')->nullable();
            $table->double('amount')->default(0);
            $table->foreignId('currency_id')->nullable()->references('id')->on('currencies')->nullOnDelete();
            $table->bigInteger('to_from_id')->nullable();
            $table->date('month');
            $table->longText('description')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->integer('type'); // EXPAND, INCOME
            $table->integer('status'); //(COMPLEATED, SENDED, REJECTED)
            $table->integer('input_type')->default(1); // MENUL, IMPORT
            $table->bigInteger('tr_id')->nullable();
            $table->json('logs')->nullable();
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('tr_cashs');
    }
};
