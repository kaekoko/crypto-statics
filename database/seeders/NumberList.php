<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use App\Http\Controllers\CryptoController;

class NumberList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $times = Section::get();
        $basedata = new CryptoController;
        foreach($times as $time){
            $am = date('h:i A', strtotime($time->section));
            $time_data = [
                "buy" => "Coming Soon",
                "sell" => "Coming Soon",
                "2d" => "Coming Soon",
                "id" => $time->id,
                "time" => $am
            ];
            array_push($data, $time_data);
        }
        $basedata->list($data);
    }
}
