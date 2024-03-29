<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_records', function (Blueprint $table) {
            $table->id();
            $table->string('record_time')->nullable();
            $table->date('record_date');
            $table->string('number')->nullable();
            $table->string('buy')->nullable();
            $table->string('sell')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_records');
    }
}
