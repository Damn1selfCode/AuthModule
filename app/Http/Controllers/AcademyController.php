<?php

namespace App\Http\Controllers;


use App\Models\Academy;

use Illuminate\Http\Request;
use App\Category;
use App\Video;
use Illuminate\Support\Facades\Auth;


class AcademyController extends Controller

{
    public function mostrarCategorias($ruta_categoria)
    {
        $categoriaModel = new Academy();
        $categoriaEspecifica = $categoriaModel->where('ruta_categoria', $ruta_categoria)->first();

        $categorias = [$categoriaEspecifica];

        // Obten la suscripción del usuario actual
        $user = Auth::user();

        $suscripcion = ($user->suscripcion === null) ? 0 : $user->suscripcion->suscripcion; // Validar en caso sea nuevo usario, Asume que el nombre del atributo en la tabla "suscripcion" es "suscripcion"

        return view('academy', compact('categorias', 'suscripcion'));
    }


    public function mostrarAcademia()
    {
        $categorias = Academy::with('videos')->get();

        // Obten la suscripción del usuario actual

        $user = Auth::user();
        $suscripcion = ($user->suscripcion === null) ? 0 : $user->suscripcion->suscripcion; // Validar en caso sea nuevo usario, Asume que el nombre del atributo en la tabla "suscripcion" es "suscripcion"

        return view('home', compact('categorias', 'suscripcion'));
    }

    /*public function mostrarCategorias($ruta_categoria)
    {
        $categoriaModel = new Academy();
        $categoriaEspecifica = $categoriaModel->where('ruta_categoria', $ruta_categoria)->first();

        $categorias = [$categoriaEspecifica];

        // Obten la suscripción del usuario actual
        $user = Auth::user();
        $suscripcion = $user->suscripcion->suscripcion; // Asume que el nombre del atributo en la tabla "suscripcion" es "suscripcion"

        return view('academy', compact('categorias', 'suscripcion'));
    }

    public function mostrarAcademia()
    {
        $categorias = Academy::with('videos')->get();

        // Obten la suscripción del usuario actual
        $user = Auth::user();
        $suscripcion = $user->suscripcion->suscripcion; // Asume que el nombre del atributo en la tabla "suscripcion" es "suscripcion"

        return view('home', compact('categorias', 'suscripcion'));
    }*/
}
