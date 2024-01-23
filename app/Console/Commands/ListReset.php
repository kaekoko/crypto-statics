<?php

namespace App\Console\Commands;

use App\Models\Section;
use Illuminate\Console\Command;
use App\Http\Controllers\CryptoController;

class ListReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = [];
        
        $basedata = new CryptoController;

        $basedata->remove();
    
        $times = Section::pluck('section')->toArray();
        foreach($times as $time){
            $time_data = [
                "buy" => "Coming Soon",
                "sell" => "Coming Soon",
                "2d" => "Coming Soon",
                "time" => date('h:i A', strtotime($time))
            ];
            array_push($data, $time_data);
        }

        $basedata->list($data);
    }
}
