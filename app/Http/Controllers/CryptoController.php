<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Engine\Engine;
use App\Models\OffDay;
use App\Models\BetSlip;
use App\Models\Section;
use App\Models\Setting;
use App\Models\AutoRecord;
use App\Models\LiveRecord;
use App\Models\LuckyNumber;
use App\Models\CustomRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Array_;

class CryptoController extends Controller
{
    private $database;

    public function __construct()
    {
        $this->database = \App\Services\FirebaseService::connect();
    }

    public function create(Array $array) 
    {
        $data = $this->database->getReference('number/data')->getValue();
        if(!empty($data)){
            $this->database->getReference('number/data')
            ->update([
                'number' => $array['number'],
                'buy' => $array['buy'],
                'sell' => $array['sell'],
            ]);
        } else {
            $this->database
            ->getReference('number/data')
            ->set([
                'number' => $array['number'] ,
                'buy' => $array['buy'],
                'sell' => $array['sell']
            ]);
        }
        
       Log::info('Crypto Data Updated');
    }

    public function list(Array $times){
        $this->database
        ->getReference('list/data')
        ->set($times);
       Log::info('Crypto is listed');
    }
   
    public function getlist(){
       return $this->database
        ->getReference('list/data')
        ->getValue();
    }

    public function remove(){
        $this->database
        ->getReference('list/data')
        ->remove();

       Log::info('Crypto is deleted');
    }

    public function removeKey($key){
        $this->database
        ->getReference('list/data/' . $key)
        ->remove();

       Log::info('Crypto Section is deleted');
    }

    public function test(){
        $ch = curl_init();
        $url = 'https://api1.binance.com/api/v3/ticker/bookTicker?symbol=BTCUSDT';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        $final = json_decode($data);
        if(strpos($final->bidPrice, '.') != false){
            $pre_ex = explode('.', $final->bidPrice);
            
            if(strlen($pre_ex[1]) > 1){
                $bidprice = number_format($final->bidPrice, 2, '.', '');
                return $bidprice;
            } else {
                $bidprice = $pre_ex[0] . '.' . $pre_ex[1] . '0';
            }
        } else {
            $bidprice = $final->bidPrice . '.00';
        }

        return $de;
    }

    public function update_list(Array $res,$section){
        $data = $this->database->getReference('list/data')->getValue();
        foreach($data as $key => $datum){
            if($section == $datum['time']){
                $this->database->getReference('list/data/' . $key)
                ->update([
                    "buy" => $res['buy'],
                    "sell" => $res['sell'],
                    "2d" => $res['number'],
                    "time" => date('h:i A', strtotime($section))
                ]);
            }
        }
    }


    public function fbdata(Array $res,$section){
        $data = $this->database->getReference('list/data')->getValue();
        return $data;
        foreach($data as $key => $datum){
            if($section == $datum['time']){
                $this->database->getReference('list/data/' . $key)
                ->update([
                    "buy" => $res['buy'],
                    "sell" => $res['sell'],
                    "2d" => $res['number'],
                    "time" => date('h:i A', strtotime($section))
                ]);
            }
        }
    }
    public function offdaystatus(Request $request){
        $diffWithGMT=6*60*60+30*60;
        $current_date = gmdate('Y-m-d', time()+$diffWithGMT);
        $find = OffDay::where('date', $current_date)->first();
        if(!empty($find)){
            $status = 1;
        } else {
            $status = 0;
        }
        return response()->json([
            "status" => $status
        ]);
    }

    public function filter_date(Request $request){
        $from = $request->from;
        $to = $request->to;
        $nor_array = [];
        
        $normals = AutoRecord::whereBetween('record_date', [$from,$to])->get();
        foreach($normals as $normal){
            $nor_data = [
                "buy" =>  $normal->buy,
                // "sell" => $normal->sell,
                "2d" => $normal->number,
                "date" => $normal->record_date,
                "time" => $normal->record_time,
                "datetime" => str_replace('00:00:00', '', $normal->record_date . $normal->record_time)
            ];
            array_push($nor_array, $nor_data);
        }

        return response()->json([
            "data" => $nor_array
        ]); 
       
    }

    public function live(){
        $datum = $this->database->getReference('number/data')->getValue();
        $diffWithGMT=6*60*60+30*60;
        $timing = gmdate('s', time()+$diffWithGMT);
        $curtime = gmdate('H:i', time()+$diffWithGMT);
        $now = gmdate('Y-m-d H:i:s', time()+$diffWithGMT);
        $now_time = gmdate('Y-m-d h:i A', time()+$diffWithGMT);
        $ex_date = explode(' ', $now_time);
        $date = gmdate('Y-m-d', time()+$diffWithGMT);
        $get_rec = CustomRecord::where('record_date', '=', $date)->where('record_time', '=', $ex_date[1] . ' ' . $ex_date[2])->where('number', '!=', '-')->first();
        if(!empty($get_rec)){

            // $ex_one = explode('.', $datum['sell']);
            $ex_two = explode('.', $datum['buy']);
            $split_db = str_split($get_rec->number);
            $cut = substr($ex_two[0], 0, -1);
            $bindfront = $cut . $split_db[0];
            $cut_decimal = substr($ex_two[1], 0, -1);
            $bindback = $cut_decimal . $split_db[1];
            $lastbind = $bindfront . '.' . $bindback;
            


            if(number_format($timing) >= 0 && number_format($timing) <= 20){
                $same_data_lucky = DB::table('lucky_numbers')->where('section', $get_rec->record_time)->where('date', $date)->first();
                if (empty($same_data_lucky)) {
                    $new = new AutoRecord();
                    $new->record_date = $get_rec->record_date;
                    $new->record_time = $get_rec->record_time;
                    $new->number = $get_rec->number;
                    $new->buy = $lastbind;
                    $new->sell = $datum['sell'];
                    $new->save();
        
                    $lucky = new LuckyNumber();
                    $lucky->number = $get_rec->number;
                    $lucky->section = $get_rec->record_time;
                    $lucky->date = $get_rec->record_date;
                    $lucky->save();

                    $setting = Setting::first();
                    $slips = BetSlip::where('date', $date)->where('section', $get_rec->record_time)->get();
                    foreach($slips as $slip){
                        if($slip->number == $lucky->number){
                            $slip->status = 1;
                            $slip->save();
                        } else {
                            $slip->status = 0;
                            $slip->save();
                        }
                    }
                   $totalslip = Bet::where('date', $date)->where('section', $get_rec->record_time)->get();
                   foreach($totalslip as $total){
                        $findwin = BetSlip::where('status', 1)->where('bet_id', $total->id)->first();
                        if(!empty($findwin)){
                            $total->reward = $setting->odd * $findwin->amount;
                            $total->status = 1;
                        } else {
                            $total->status = 0;
                        }
                        $total->save();
                   }

                    


                    $this->update_list([
                        "number" => $get_rec->number,
                        "buy" => $lastbind,
                        "sell" => $datum['sell']
                    ], $get_rec->record_time);

                    $this->create([
                        "number" => $get_rec->number,
                        "buy" => $lastbind,
                        "sell" => $datum['sell']
                    ]);

                    $data_app = [
                        "buy" => $new->buy,
                        "sell" => $new->sell,
                        "2d" => $get_rec->number,
                        "time" => date($now, time()),
                        "text" => "lucky",
                    ];
                } else {
                    $data_app = [
                        "buy" => $datum['buy'],
                        "sell" => $datum['sell'],
                         "2d" => $datum['number'],
                        "time" => date($now, time()),
                        "text" => "fire",
                    ];
                }
            } else {
                $data_app = [
                    "buy" => $datum['buy'],
                    "sell" => $datum['sell'],
                    "2d" => $datum['number'],
                    "time" => date($now, time()),
                    "text" => "fire",
                ];
            }
        } else {
            $times = Section::pluck('section')->toArray();
            $etxt = "fire";
            foreach($times as $t){
                $time = date("H:i", strtotime($t));
                if($curtime == $time){
                    if(number_format($timing) >= 0 && number_format($timing) <= 20){
                        $same_data_lucky = DB::table('lucky_numbers')->where('section', $ex_date[1] . ' ' . $ex_date[2])->where('date', $date)->first();
                        if(empty($same_data_lucky)){
                            $etxt = "lucky";
                            
                            $new = new AutoRecord();
                            $new->record_date = $date;
                            $new->record_time = $ex_date[1] . ' ' . $ex_date[2];
                            $new->number = $datum['number'];
                            $new->buy = $datum['buy'];
                            $new->sell = $datum['sell'];
                            $new->save();
    
                            $lucky = new LuckyNumber();
                            $lucky->number = $datum['number'];
                            $lucky->section = $ex_date[1] . ' ' . $ex_date[2];
                            $lucky->date = $date;
                            $lucky->save();

                            $setting = Setting::first();
                            $slips = BetSlip::where('date', $date)->where('section', $lucky->section)->get();
                            foreach($slips as $slip){
                                if($slip->number == $lucky->number){
                                    $slip->status = 1;
                                    $slip->save();
                                } else {
                                    $slip->status = 0;
                                    $slip->save();
                                }
                            }
                            $totalslip = Bet::where('date', $date)->where('section', $lucky->section)->get();
                            foreach($totalslip as $total){
                                $findwin = BetSlip::where('status', 1)->where('bet_id', $total->id)->first();
                                if(!empty($findwin)){
                                    $total->reward = $setting->odd * $findwin->amount;
                                    $total->status = 1;
                                } else {
                                    $total->status = 0;
                                }
                                $total->save();
                            }



                            $this->update_list([
                                "number" => $datum['number'],
                                "buy" => $datum['buy'],
                                "sell" => $datum['sell']
                            ], $ex_date[1] . ' ' . $ex_date[2]);
                        }
                    }
                }
            }
            $data_app = [
                "buy" => $datum['buy'],
                "sell" => $datum['sell'],
                "2d" => $datum['number'],
                "time" => date($now, time()),
                "text" => $etxt,
            ];
        }
        return response()->json($data_app);
    }



    public function TestingData(){
        $datum = $this->database->getReference('number/data')->getValue();
        $diffWithGMT=6*60*60+30*60;
        $timing = gmdate('s', time()+$diffWithGMT);
        $curtime = gmdate('H:i', time()+$diffWithGMT);
        $now = gmdate('Y-m-d H:i:s', time()+$diffWithGMT);
        $now_time = gmdate('Y-m-d h:i A', time()+$diffWithGMT);
        $ex_date = explode(' ', $now_time);
        $date = gmdate('Y-m-d', time()+$diffWithGMT);
        $get_rec = CustomRecord::where('record_date', '=', $date)->where('record_time', '=', $ex_date[1] . ' ' . $ex_date[2])->where('number', '!=', '-')->first();
      
        return  $get_rec;

        if(!empty($get_rec)){

            // $ex_one = explode('.', $datum['sell']);
            $ex_two = explode('.', $datum['buy']);
            $split_db = str_split($get_rec->number);
            $cut = substr($ex_two[0], 0, -1);
            $bindfront = $cut . $split_db[0];
            $cut_decimal = substr($ex_two[1], 0, -1);
            $bindback = $cut_decimal . $split_db[1];
            $lastbind = $bindfront . '.' . $bindback;
            


            if(number_format($timing) >= 0 && number_format($timing) <= 20){
                $same_data_lucky = DB::table('lucky_numbers')->where('section', $get_rec->record_time)->where('date', $date)->first();
                if (empty($same_data_lucky)) {
                    $new = new AutoRecord();
                    $new->record_date = $get_rec->record_date;
                    $new->record_time = $get_rec->record_time;
                    $new->number = $get_rec->number;
                    $new->buy = $lastbind;
                    $new->sell = $datum['sell'];
                    $new->save();
        
                    $lucky = new LuckyNumber();
                    $lucky->number = $get_rec->number;
                    $lucky->section = $get_rec->record_time;
                    $lucky->date = $get_rec->record_date;
                    $lucky->save();

                    $setting = Setting::first();
                    $slips = BetSlip::where('date', $date)->where('section', $get_rec->record_time)->get();
                    foreach($slips as $slip){
                        if($slip->number == $lucky->number){
                            $slip->status = 1;
                            $slip->save();
                        } else {
                            $slip->status = 0;
                            $slip->save();
                        }
                    }
                   $totalslip = Bet::where('date', $date)->where('section', $get_rec->record_time)->get();
                   foreach($totalslip as $total){
                        $findwin = BetSlip::where('status', 1)->where('bet_id', $total->id)->first();
                        if(!empty($findwin)){
                            $total->reward = $setting->odd * $findwin->amount;
                            $total->status = 1;
                        } else {
                            $total->status = 0;
                        }
                        $total->save();
                   }

                    


                    $this->update_list([
                        "number" => $get_rec->number,
                        "buy" => $lastbind,
                        "sell" => $datum['sell']
                    ], $get_rec->record_time);

                    $this->create([
                        "number" => $get_rec->number,
                        "buy" => $lastbind,
                        "sell" => $datum['sell']
                    ]);

                    $data_app = [
                        "buy" => $new->buy,
                        "sell" => $new->sell,
                        "2d" => $get_rec->number,
                        "time" => date($now, time()),
                        "text" => "lucky",
                    ];
                } else {
                    $data_app = [
                        "buy" => $datum['buy'],
                        "sell" => $datum['sell'],
                         "2d" => $datum['number'],
                        "time" => date($now, time()),
                        "text" => "fire",
                    ];
                }
            } else {
                $data_app = [
                    "buy" => $datum['buy'],
                    "sell" => $datum['sell'],
                    "2d" => $datum['number'],
                    "time" => date($now, time()),
                    "text" => "fire",
                ];
            }
        } else {
            $times = Section::pluck('section')->toArray();
            $etxt = "fire";
            foreach($times as $t){
                $time = date("H:i", strtotime($t));
                if($curtime == $time){
                    if(number_format($timing) >= 0 && number_format($timing) <= 20){
                        $same_data_lucky = DB::table('lucky_numbers')->where('section', $ex_date[1] . ' ' . $ex_date[2])->where('date', $date)->first();
                        if(empty($same_data_lucky)){
                            $etxt = "lucky";
                            
                            $new = new AutoRecord();
                            $new->record_date = $date;
                            $new->record_time = $ex_date[1] . ' ' . $ex_date[2];
                            $new->number = $datum['number'];
                            $new->buy = $datum['buy'];
                            $new->sell = $datum['sell'];
                            $new->save();
    
                            $lucky = new LuckyNumber();
                            $lucky->number = $datum['number'];
                            $lucky->section = $ex_date[1] . ' ' . $ex_date[2];
                            $lucky->date = $date;
                            $lucky->save();

                            $setting = Setting::first();
                            $slips = BetSlip::where('date', $date)->where('section', $lucky->section)->get();
                            foreach($slips as $slip){
                                if($slip->number == $lucky->number){
                                    $slip->status = 1;
                                    $slip->save();
                                } else {
                                    $slip->status = 0;
                                    $slip->save();
                                }
                            }
                            $totalslip = Bet::where('date', $date)->where('section', $lucky->section)->get();
                            foreach($totalslip as $total){
                                $findwin = BetSlip::where('status', 1)->where('bet_id', $total->id)->first();
                                if(!empty($findwin)){
                                    $total->reward = $setting->odd * $findwin->amount;
                                    $total->status = 1;
                                } else {
                                    $total->status = 0;
                                }
                                $total->save();
                            }



                            $this->update_list([
                                "number" => $datum['number'],
                                "buy" => $datum['buy'],
                                "sell" => $datum['sell']
                            ], $ex_date[1] . ' ' . $ex_date[2]);
                        }
                    }
                }
            }
            $data_app = [
                "buy" => $datum['buy'],
                "sell" => $datum['sell'],
                "2d" => $datum['number'],
                "time" => date($now, time()),
                "text" => $etxt,
            ];
        }
        return response()->json($data_app);
    }

    // public function luckynumber_history(){
    //     $data=LuckyNumber::all();
    //     return response()->json($data);
    // }

    public function luckynumber_history(Request $request)
    {
        $this->validate($request, [
            "start_date" => "required",
            "end_date" => "required"
        ]);
        $start = $request->query('start_date');
        $end = $request->query('end_date');
      
        $histories = LuckyNumber::orderBy('id', 'desc')->whereBetween('date', [$start, $end]);
       
        return response()->json([
            'data' => $histories->get()
        ], 200);
    }
}
