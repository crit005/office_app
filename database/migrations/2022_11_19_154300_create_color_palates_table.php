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
        Schema::create('color_palates', function (Blueprint $table) {
            $table->id();
            $table->string('palet_name');
            $table->string('bg_color');
            $table->string('text_color');
            $table->string('bw_color');
            $table->timestamps();
        });
        DB::table('color_palates')->insert(
            array(
                ['palet_name' => 'Peony Rose', 'bg_color' => '#277256', 'text_color' => '#94D9BF', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Peony Rose', 'bg_color' => '#A8D889', 'text_color' => '#277256', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Peony Rose', 'bg_color' => '#F34481', 'text_color' => '#FCCBCA', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Peony Rose', 'bg_color' => '#FCCBCA', 'text_color' => '#F34481', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Peony Rose', 'bg_color' => '#FFEFF3', 'text_color' => '#BE5871', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Swimming with the Whales', 'bg_color' => '#78C0E0', 'text_color' => '#150578', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Swimming with the Whales', 'bg_color' => '#449DD1', 'text_color' => '#0E0E52', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Swimming with the Whales', 'bg_color' => '#192BC2', 'text_color' => '#78C0E0', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Swimming with the Whales', 'bg_color' => '#150578', 'text_color' => '#78C0E0', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Swimming with the Whales', 'bg_color' => '#0E0E52', 'text_color' => '#78C0E0', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Phoebe', 'bg_color' => '#F1615D', 'text_color' => '#9E483E', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Phoebe', 'bg_color' => '#FF8761', 'text_color' => '#883936', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Phoebe', 'bg_color' => '#FFC575', 'text_color' => '#F1615D', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Phoebe', 'bg_color' => '#F1FAC6', 'text_color' => '#606A30', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Phoebe', 'bg_color' => '#79E6E3', 'text_color' => '#4B8B89', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cherry Soda', 'bg_color' => '#211103', 'text_color' => '#FEF2E3', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cherry Soda', 'bg_color' => '#3D1308', 'text_color' => '#FEF2E3', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cherry Soda', 'bg_color' => '#7B0D1E', 'text_color' => '#FEF2E3', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cherry Soda', 'bg_color' => '#9F2042', 'text_color' => '#FEF2E3', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cherry Soda', 'bg_color' => '#FEF2E3', 'text_color' => '#211103', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Elise', 'bg_color' => '#F69594', 'text_color' => '#636362', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Elise', 'bg_color' => '#F6BCBB', 'text_color' => '#636362', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Elise', 'bg_color' => '#F3F3EB', 'text_color' => '#595959', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Elise', 'bg_color' => '#393939', 'text_color' => '#F3F3EB', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Elise', 'bg_color' => '#595959', 'text_color' => '#F3F3EB', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cheesecake', 'bg_color' => '#895959', 'text_color' => '#D8AF83', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cheesecake', 'bg_color' => '#9E6168', 'text_color' => '#D8AF83', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cheesecake', 'bg_color' => '#D66774', 'text_color' => '#631720', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cheesecake', 'bg_color' => '#FDFAC0', 'text_color' => '#895959', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cheesecake', 'bg_color' => '#D8AF83', 'text_color' => '#FDFAC0', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Hncut Amerthyst', 'bg_color' => '#10001B', 'text_color' => '#D4BFD3', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Hncut Amerthyst', 'bg_color' => '#632D5F', 'text_color' => '#FECDFA', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Hncut Amerthyst', 'bg_color' => '#A87BA4', 'text_color' => '#632D5F', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Hncut Amerthyst', 'bg_color' => '#FECDFA', 'text_color' => '#9688BB', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Hncut Amerthyst', 'bg_color' => '#9688BB', 'text_color' => '#FECDFA', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Beach Hmbrella', 'bg_color' => '#9AE8FC', 'text_color' => '#00A5A8', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Beach Hmbrella', 'bg_color' => '#01C6C9', 'text_color' => '#E4FAFF', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Beach Hmbrella', 'bg_color' => '#FC6698', 'text_color' => '#FFD9E8', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Beach Hmbrella', 'bg_color' => '#FF9BC2', 'text_color' => '#AB4265', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Beach Hmbrella', 'bg_color' => '#FCFF94', 'text_color' => '#FC6698', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cotton Cat', 'bg_color' => '#50E4E3', 'text_color' => '#204B4B', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cotton Cat', 'bg_color' => '#578AC7', 'text_color' => '#A3CDFF', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cotton Cat', 'bg_color' => '#7451AB', 'text_color' => '#BF96FF', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cotton Cat', 'bg_color' => '#F1A5D7', 'text_color' => '#AC3C86', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Cotton Cat', 'bg_color' => '#F5CBD7', 'text_color' => '#BF4D73', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'The Hnknown', 'bg_color' => '#A81B4A', 'text_color' => '#FFFFFF', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'The Hnknown', 'bg_color' => '#5B193E', 'text_color' => '#FFFFFF', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'The Hnknown', 'bg_color' => '#181110', 'text_color' => '#FFFFFF', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'The Hnknown', 'bg_color' => '#F66D3D', 'text_color' => '#FFFFFF', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'The Hnknown', 'bg_color' => '#FFAC40', 'text_color' => '#FFFFFF', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Rose Quartz', 'bg_color' => '#C275A1', 'text_color' => '#FDFBFE', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Rose Quartz', 'bg_color' => '#F36891', 'text_color' => '#FDFBFE', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Rose Quartz', 'bg_color' => '#FEAACC', 'text_color' => '#FDFBFE', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Rose Quartz', 'bg_color' => '#FFF1E6', 'text_color' => '#C275A1', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Rose Quartz', 'bg_color' => '#FDFBFE', 'text_color' => '#C275A1', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Mint City', 'bg_color' => '#664147', 'text_color' => '#C07D88', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Mint City', 'bg_color' => '#2F9C95', 'text_color' => '#E5F9E0', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Mint City', 'bg_color' => '#40C9A2', 'text_color' => '#E5F9E0', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Mint City', 'bg_color' => '#A3F7B5', 'text_color' => '#2F9C95', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Mint City', 'bg_color' => '#E5F9E0', 'text_color' => '#2F9C95', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Yuuki Yuuki', 'bg_color' => '#B9A1C3', 'text_color' => '#775F7F', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Yuuki Yuuki', 'bg_color' => '#775F7F', 'text_color' => '#B9A1C3', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Yuuki Yuuki', 'bg_color' => '#463F60', 'text_color' => '#B9A1C3', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Yuuki Yuuki', 'bg_color' => '#F7EB99', 'text_color' => '#B52D2D', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Yuuki Yuuki', 'bg_color' => '#B52D2D', 'text_color' => '#F7EB99', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Castle In The Sky', 'bg_color' => '#703034', 'text_color' => '#E07761', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Castle In The Sky', 'bg_color' => '#E07761', 'text_color' => '#F8E8A3', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Castle In The Sky', 'bg_color' => '#FAC78D', 'text_color' => '#703034', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Castle In The Sky', 'bg_color' => '#F8E8A3', 'text_color' => '#703034', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Castle In The Sky', 'bg_color' => '#86DDB3', 'text_color' => '#703034', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Candy Apples', 'bg_color' => '#FFA69E', 'text_color' => '#FFF7F8', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Candy Apples', 'bg_color' => '#FF7E6B', 'text_color' => '#FFF7F8', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Candy Apples', 'bg_color' => '#8C5E58', 'text_color' => '#FFF7F8', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Candy Apples', 'bg_color' => '#A9F0D1', 'text_color' => '#017E47', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Candy Apples', 'bg_color' => '#FFF7F8', 'text_color' => '#8C5E58', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Summer Smoothies', 'bg_color' => '#C36864', 'text_color' => '#632D2A', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Summer Smoothies', 'bg_color' => '#FF8482', 'text_color' => '#7D4443', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Summer Smoothies', 'bg_color' => '#B6C363', 'text_color' => '#464A29', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Summer Smoothies', 'bg_color' => '#CEE44A', 'text_color' => '#525A1E', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Summer Smoothies', 'bg_color' => '#F1FFA0', 'text_color' => '#757C45', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Potentilla', 'bg_color' => '#F0BA40', 'text_color' => '#554218', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Potentilla', 'bg_color' => '#FFEB65', 'text_color' => '#632D2A', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Potentilla', 'bg_color' => '#FEFFF9', 'text_color' => '#CCB451', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Potentilla', 'bg_color' => '#FAF697', 'text_color' => '#9A782A', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Potentilla', 'bg_color' => '#CCB451', 'text_color' => '#FFEB65', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Beyond the Boundary', 'bg_color' => '#030D45', 'text_color' => '#8999EF', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Beyond the Boundary', 'bg_color' => '#072794', 'text_color' => '#85A1FF', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Beyond the Boundary', 'bg_color' => '#31D8AF', 'text_color' => '#D3FFEB', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Beyond the Boundary', 'bg_color' => '#AAEBCD', 'text_color' => '#1E8F74', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Beyond the Boundary', 'bg_color' => '#A25E8B', 'text_color' => '#FFD3F0', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Sunset', 'bg_color' => '#F05F66', 'text_color' => '#61181C', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Sunset', 'bg_color' => '#FF7A79', 'text_color' => '#A82422', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Sunset', 'bg_color' => '#FFB152', 'text_color' => '#5C3D17', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Sunset', 'bg_color' => '#FFDF76', 'text_color' => '#534824', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Sunset', 'bg_color' => '#FFF18E', 'text_color' => '#68633D', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Chocolate Cherry Shake', 'bg_color' => '#8C1C13', 'text_color' => '#E7D7C1', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Chocolate Cherry Shake', 'bg_color' => '#BF4342', 'text_color' => '#E7D7C1', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Chocolate Cherry Shake', 'bg_color' => '#E7D7C1', 'text_color' => '#735751', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Chocolate Cherry Shake', 'bg_color' => '#A78A7F', 'text_color' => '#735751', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Chocolate Cherry Shake', 'bg_color' => '#735751', 'text_color' => '#A78A7F', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Our Love Will Transcend Hniverses', 'bg_color' => '#F6E2DD', 'text_color' => '#471A43', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Our Love Will Transcend Hniverses', 'bg_color' => '#F6B9B8', 'text_color' => '#713660', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Our Love Will Transcend Hniverses', 'bg_color' => '#F68D8D', 'text_color' => '#F6E2DD', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Our Love Will Transcend Hniverses', 'bg_color' => '#713660', 'text_color' => '#F6E2DD', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Our Love Will Transcend Hniverses', 'bg_color' => '#471A43', 'text_color' => '#D185BB', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'God of Ink', 'bg_color' => '#161530', 'text_color' => '#E6EFFC', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'God of Ink', 'bg_color' => '#464E7F', 'text_color' => '#8A99E0', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'God of Ink', 'bg_color' => '#8A99E0', 'text_color' => '#464E7F', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'God of Ink', 'bg_color' => '#E6EFFC', 'text_color' => '#161530', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'God of Ink', 'bg_color' => '#7A232A', 'text_color' => '#161530', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Searching For Fridends', 'bg_color' => '#584343', 'text_color' => '#FBFBFB', 'bw_color' => '#FFFFFF', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Searching For Fridends', 'bg_color' => '#FBFBFB', 'text_color' => '#584343', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Searching For Fridends', 'bg_color' => '#FF9D77', 'text_color' => '#584343', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Searching For Fridends', 'bg_color' => '#F46F6F', 'text_color' => '#584343', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Searching For Fridends', 'bg_color' => '#DC5151', 'text_color' => '#584343', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Citty Cat', 'bg_color' => '#D9312D', 'text_color' => '#FFF5E6', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Citty Cat', 'bg_color' => '#F8874A', 'text_color' => '#FFF5E6', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Citty Cat', 'bg_color' => '#FFE440', 'text_color' => '#A53B00', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Citty Cat', 'bg_color' => '#FFF797', 'text_color' => '#CD6026', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
                ['palet_name' => 'Citty Cat', 'bg_color' => '#FFF5E6', 'text_color' => '#F8874A', 'bw_color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
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
        Schema::dropIfExists('color_palates');
    }
};
