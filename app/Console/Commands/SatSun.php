<?php

namespace App\Console\Commands;

use App\Models\OffDay;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SatSun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sat:sun';

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
 Log::info('Testing');
return;   
        $diffWithGMT=6*60*60+30*60;
        $cur = gmdate('Y-m-d', time()+$diffWithGMT);
        $current_date = strtotime($cur);
        $day = date('D', $current_date);
        if($day == 'Sat' || $day == 'Sun'){
            $find = Offday::where('date', $cur)->first();
            if(empty($find)){
                $off = new OffDay();
                $off->date = $cur;
                $off->day = $day;
                $off->save();
    
                Log::info('Today is' . $day . '. Offday Inserted');
            } else {
                Log::info('Today is alrady Exist.');
            }
        } else {
            Log::info('Today is not offday');
        }
    }
}
