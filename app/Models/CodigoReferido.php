<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoReferido extends Model
{
    protected $table = 'codigo_referido';

    protected $fillable = [
        'codigo_referido'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
