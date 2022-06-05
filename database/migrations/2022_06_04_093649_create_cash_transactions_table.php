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
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('tr_date');
            $table->foreignId('item_id')->nullable()->references('id')->on('items')->nullOnDelete();            
            $table->string('item_name')->nullable();
            $table->double('amount')->default(0);
            $table->double('bk_amount')->default(0);
            $table->double('balance')->default(0);
            $table->double('user_balance')->default(0);
            $table->foreignId('currency_id')->nullable()->references('id')->on('currencies')->nullOnDelete();            
            $table->bigInteger('to_from')->nullable();
            $table->date('month');
            $table->longText('description')->nullable();
            $table->foreignId('owner')->nullable()->references('id')->on('users')->nullOnDelete();            
            $table->string('type');
            $table->string('status'); //(COMPLEATED, SENDED, REJECTED)
            $table->bigInteger('tr_id');
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
        Schema::dropIfExists('cash_transactions');
    }
};
