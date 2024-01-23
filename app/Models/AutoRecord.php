<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoRecord extends Model
{
    use HasFactory;

    protected $fillable = ['record_time', 'record_date', 'number', 'buy', 'sell'];

    protected $table = "auto_records";
}
