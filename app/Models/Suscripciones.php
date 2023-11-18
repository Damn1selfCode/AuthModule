<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suscripciones extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'subscriptions'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
