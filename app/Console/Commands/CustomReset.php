<?php

namespace App\Console\Commands;

use App\Models\CustomRecord;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CustomReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:reset';

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
        $diffWithGMT=6*60*60+30*60;
        $date = gmdate('Y-m-d', time()+$diffWithGMT);
        $customs = CustomRecord::get();
        foreach($customs as $custom){
            $custom->record_date = $date;
            $custom->number = '-';
            $custom->save();
        }
        Log::info('Reset Custom Number');
    }
}
