<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academy extends Model

{

    protected $table = 'categorias';

    public function getCategorias($item = null, $valor = null)
    {
        if ($item && $valor) {
            return $this->where($item, $valor)->first();
        } else {
            return $this->get();
        }
    }


    public function videos()
    {
        return $this->hasMany(Video::class, 'id_cat', 'id_cat');
    }
    


}
