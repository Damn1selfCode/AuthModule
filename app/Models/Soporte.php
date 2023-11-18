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
        'papelera', // Asegúrate de agregar 'papelera' en $fillable
    ];

    public function remitenteRelacion()
    {
        return $this->belongsTo(User::class, 'remitente');
    }
    public function receptorRelacion()
    {
        return $this->belongsTo(User::class, 'receptor');
    }

    protected $papelera;
    //CONTADOR ENVIADOS
    public static function countEnviados($userId)
    {
        return self::where('remitente', $userId)
            ->where(function ($query) use ($userId) {
                $query->where('tipo', 'enviado')
                    ->orWhere(function ($query) use ($userId) {
                        $query->where('tipo', 'papelera')
                            ->whereJsonDoesntContain('papelera', $userId);
                    });
            })
            ->count();
    }

    //CONTADOR RECIBIDOS
    public static function countRecibidos($userId)
    {
        return self::where('receptor', $userId)
            ->whereIn('tipo', ['enviado', 'papelera'])
            ->where(function ($query) use ($userId) {
                $query->where('tipo', 'enviado')
                    ->orWhere(function ($query) use ($userId) {
                        $query->where('tipo', 'papelera')
                            ->whereJsonDoesntContain('papelera', $userId);
                    });
            })
            ->count();
    }
    //CONTADOR PAPELERA
    public static function countPapelera($userId)
    {
        return self::where('tipo', 'papelera')
            ->whereJsonContains('papelera', $userId)
            ->count();
    }
}
