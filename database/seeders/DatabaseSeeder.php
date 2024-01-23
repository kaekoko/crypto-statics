<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\NumberList;
use Database\Seeders\CustomSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            NumberList::class,
            CustomSeeder::class
        ]);
    }
}
