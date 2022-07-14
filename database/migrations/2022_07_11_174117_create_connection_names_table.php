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
        Schema::create('connection_names', function (Blueprint $table) {
            $table->id();
            $table->string('system_name');
            $table->string('connection_name');
            $table->string('server_name');
            $table->bigInteger('new_member')->default(0);
            $table->bigInteger('active_member')->default(0);
            $table->bigInteger('total_member')->default(0);
            $table->string('status');
            $table->timestamps();
        });

        DB::table('connection_names')->insert(
            array(
                // Server
                ['system_name' => '6QPOKER', 'connection_name' => '6qpokerdb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'AUDISIPOKER', 'connection_name' => 'audisipokerdb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'BANDARGAMING', 'connection_name' => 'bandargamingdb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'BANDARNAGA', 'connection_name' => 'bandarnagadb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'BANDARVIP', 'connection_name' => 'bandarvipdb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'CBOGAMING', 'connection_name' => 'cbogamingdb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'CBOPOKER', 'connection_name' => 'cbopokerdb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'FIFACASH', 'connection_name' => 'fifacashdb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'JUDIE303', 'connection_name' => 'judie303', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'KINGBOOKIE', 'connection_name' => 'kingbookiedb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'KOIN4D', 'connection_name' => 'koin4ddb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'MAINKARTUQQ', 'connection_name' => 'mainkartuqq', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'MAXBETQQ', 'connection_name' => 'maxbetqqdb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'MBOPLAY', 'connection_name' => 'mboplaydb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'NAGA4D', 'connection_name' => 'naga4ddb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'QQGAMING', 'connection_name' => 'qqgamingdb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'RAJAGAMING', 'connection_name' => 'rajagamingdb', 'server_name' => 'SERVER', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                // Serverth
                ['system_name' => 'HENGHENGCLUB', 'connection_name' => 'henghengclubdb', 'server_name' => 'SERVERTH', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'CHOKDEECLUB', 'connection_name' => 'chokdeeclubdb', 'server_name' => 'SERVERTH', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'DEEDEECLUB', 'connection_name' => 'deedeeclubdb', 'server_name' => 'SERVERTH', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'LUCKYCLUB88', 'connection_name' => 'luckyclub88', 'server_name' => 'SERVERTH', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'POKERPAN', 'connection_name' => 'pokerpandb', 'server_name' => 'SERVERTH', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'QQGAMINGTHAI', 'connection_name' => 'qqgamingdbth', 'server_name' => 'SERVERTH', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'SAWADEEPOKER', 'connection_name' => 'sawadeepokerdb', 'server_name' => 'SERVERTH', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'WECHATPOKER', 'connection_name' => 'wechatpokerdb', 'server_name' => 'SERVERTH', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                // Serverj
                ['system_name' => 'BOOKIEPALACE', 'connection_name' => 'bookiepalacedb', 'server_name' => 'SERVERJ', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'QQCROWN', 'connection_name' => 'qqcrowndb', 'server_name' => 'SERVERJ', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'QQMEGA', 'connection_name' => 'qqmegadb', 'server_name' => 'SERVERJ', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'QQPALACE', 'connection_name' => 'qqpalacedb', 'server_name' => 'SERVERJ', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'QQPLAZA', 'connection_name' => 'qqplazadb', 'server_name' => 'SERVERJ', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['system_name' => 'WASITBOLA', 'connection_name' => 'wasitboladb', 'server_name' => 'SERVERJ', 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()]

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
        Schema::dropIfExists('connection_names');
    }
};
