<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use App\Http\Controllers\CryptoController;

class KeyAdd extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $basedata = new CryptoController;
        $fb_data = $basedata->getlist();
        foreach($fb_data as $key => $datum){
            $t = Section::where('id', $datum['id'])->first();
            $t->key_id = $key;
            $t->save();
        }
    }
}
