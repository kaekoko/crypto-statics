<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomRecord extends Model
{
    use HasFactory;

    protected $fillable = ['record_time', 'record_date', 'number'];

    protected $table = "custom_records";
}
