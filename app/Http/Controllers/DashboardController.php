<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Section;
use App\Models\CustomRecord;
use App\Models\OffDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function section_view(){
        $sections = Section::get();
        return view('section', compact('sections'));
    }

    public function offdays(){
        $offdays = OffDay::get();
        return view('offday', compact('offdays'));
    }

    public function deleteoffday($id){
        $offday = OffDay::findOrFail($id);
        $offday->delete();
        return [
            "message" => "success"
        ];
    }

    public function createoffday(Request $request){
        $timestamp = strtotime($request->date);

        $day = date('D', $timestamp);
        $date = date('Y-m-d', $timestamp);
        $find = OffDay::where('date',$date)->first();
        if(empty($find)){
            $off = new OffDay();
            $off->day = $day;
            $off->date = $date;
            $off->save();
        }
        return back();
    }

    public function create_section(Request $request){
        $res = [];
        $diffWithGMT=6*60*60+30*60;
        $date = gmdate('Y-m-d', time()+$diffWithGMT);
        $section = $request->section;
        $new = new Section();
        $new->section = $section;
        $new->date = $date;
        $new->save();

        $times = Section::get();
        $fb = new CryptoController();
        foreach($times as $time){
            $am = date('h:i A', strtotime($time->section));
            $time_data = [
                "buy" => "Coming Soon",
                "sell" => "Coming Soon",
                "2d" => "Coming Soon",
                "id" => $time->id,
                "time" => $am
            ];
            array_push($res, $time_data);
        }
        $fb->list($res);

        $fb_data = $fb->getlist();

        foreach($fb_data as $key => $datum){
            $t = Section::where('id', $datum['id'])->first();
            $t->key_id = $key;
            $t->save();
        }

        return response()->json([
            "message" => "success",
            "data" => date('h:i A', strtotime($new->section))
        ]);
    }

    public function manual_view(){
        $customs = CustomRecord::get();
        return view('manual', compact('customs'));
    }

    public function create_manual(Request $request,$id){
        $find = CustomRecord::findOrFail($id);
        $find->number = $request->number;
        $find->save();

        return response()->json([
            "message" => "success"
        ]);
    }

    public function log(Request $request){
        $date = new Carbon($request->get('date', today()));
        $filePath = storage_path("logs/laravel-{$date->format('Y-m-d')}.log");
        $data = [];
        if(file_exists($filePath)){
            $data = [
                "lastModified" => new Carbon(File::lastModified($filePath)),
                'size' => File::size($filePath),
                'file' => File::get($filePath)
            ];
        }

        return view('log', compact('date', 'data'));
    } 

    public function delete_section($id){
        $section = Section::findOrFail($id);
        $section->delete();

        $fb = new CryptoController();
        $fb->removeKey($section->key_id);

        return back();
    }
}
