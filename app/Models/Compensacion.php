<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suscripciones extends Model
{
    protected $table = 'compensacion';

    protected $fillable = [
        'compensacion'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
