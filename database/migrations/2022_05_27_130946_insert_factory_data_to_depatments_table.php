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
        DB::table('depatments')->insert(
            array(
                ['name' => 'ACC', 'position' => 1, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'FIFA', 'position' => 2, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'BVIP', 'position' => 3, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'KB/JD', 'position' => 4, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'BP', 'position' => 5, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'TOGEL', 'position' => 6, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'POKER', 'position' => 7, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'QQ', 'position' => 8, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'BandarGaming', 'position' => 9, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'MBO', 'position' => 10, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'RajaGaming', 'position' => 11, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'CBOGaming', 'position' => 12, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Chokdee', 'position' => 13, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Lucky', 'position' => 14, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'HengHeng', 'position' => 15, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'DeeDee', 'position' => 16, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Acc Thai', 'position' => 17, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'PK/THAI', 'position' => 18, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'QQ Thai', 'position' => 19, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'OFFICE', 'position' => 20, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'QQPlaza', 'position' => 21, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'QQMega', 'position' => 22, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'QQCrown', 'position' => 23, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'QQPalace', 'position' => 24, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Wasit Bola', 'position' => 25, 'created_by' => 1, 'status' => 'ENABLED', 'created_at' => now(), 'updated_at' => now()],
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
        DB::table('depatments')->truncate();
    }
};
