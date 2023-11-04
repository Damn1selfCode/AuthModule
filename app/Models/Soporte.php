<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    protected $table = 'soporte';
    protected $fillable = [
        'remitente',
        'receptor',
        'asunto',
        'mensaje',
        'adjuntos',
        'tipo',
    ];
}
