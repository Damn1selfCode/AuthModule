<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'suscripcion';

    protected $fillable = [
        'suscripcion' // Asegúrate de tener el atributo 'suscripcion' en el array $fillable
        // Otros atributos que permites asignación masiva
        // 'active_until',
        // 'user_id',
        // 'plan_id',
    ];
    protected $dates = [
        'active_until',

    ];
    //registro user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    //si la suscripcion tiene una fehca activa mayor a la actual
    public function isActive()
    {
        return $this->active_unitl->gt(now());
    }
}
/*
class Subscription extends Model
{
    protected $table = 'suscripcion';

    //registro user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}*/
