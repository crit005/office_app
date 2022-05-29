<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('items')->insert(
            array(
                ['name' => 'Travelling', 'position' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'ENABLED'],
                ['name' => 'Perlengkapan Ktr', 'position' => 2, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'ENABLED'],
                ['name' => 'Konsumsi Ktr', 'position' => 3, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'ENABLED'],
                ['name' => 'Entertainment', 'position' => 4, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'ENABLED'],
                ['name' => 'Internet', 'position' => 5, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'ENABLED'],
                ['name' => 'Visa', 'position' => 6, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'ENABLED'],
                ['name' => 'Exchange', 'position' => 0, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'SYSTEM'],
                ['name' => 'Close Cashdrawer', 'position' => 0, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'SYSTEM'],
                ['name' => 'Start Cashdrawer', 'position' => 0, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'SYSTEM'],
                ['name' => 'Add Cash', 'position' => 0, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'SYSTEM'],
                ['name' => 'Draw Cash', 'position' => 0, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'SYSTEM'],
                ['name' => 'Transfer', 'position' => 0, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'SYSTEM'],
                ['name' => 'Others', 'position' => 333, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(), 'status' => 'ENABLED']
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
        DB::table('items')->truncate();
    }
};
