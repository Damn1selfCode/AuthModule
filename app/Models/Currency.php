<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    protected $primarykey = 'iso';
    public $incrementing = false;

    protected $fillable = [
        'iso'
    ];
}
