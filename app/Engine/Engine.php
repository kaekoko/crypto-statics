<?php

namespace App\Engine;

use App\Models\LiveRecord;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\CryptoController;
use GuzzleHttp\Psr7\Request;

class Engine{

     public static function tingo(){
        $diffWithGMT=6*60*60+30*60;
        $ch = curl_init();
        $url = 'https://api1.binance.com/api/v3/ticker/bookTicker?symbol=BTCUSDT';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        $de = json_decode($data);
        $final = $de;
        $now = date('Y-m-d H:i:s');
        $onlydate = date('Y-m-d');
        if(strpos($final->bidPrice, '.') != false){
            $pre_ex = explode('.', $final->bidPrice);
            if(strlen($pre_ex[1]) > 1){
                $bidprice = number_format($final->bidPrice, 2, '.', '');
            } else {
                $bidprice = $pre_ex[0] . '.' . $pre_ex[1] . '0';
            }
        } else {
            $bidprice = $final->bidPrice . '.00';
        }

        $ex_one = explode('.', $bidprice);
        $first = substr($ex_one[0], -1);
        $second = substr($ex_one[1], -1);
    

        $basedata = new CryptoController;

        $basedata->create([
            "number" =>$first . $second,
            "buy" => $bidprice,
            "sell" => "0000:00"
        ]);
        
        $basedata->live();

        Log::info('Cryto Numbers keep working.');
    }
}