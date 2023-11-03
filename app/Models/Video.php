<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public function category()
    {
        return $this->belongsTo(Academy::class, 'id_cat', 'id_cat');
    }
}
