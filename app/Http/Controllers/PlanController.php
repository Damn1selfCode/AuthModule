<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanController extends Controller
{
    //usuario autenticado puede acceder
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $planes = null;
        return view('perfil.planes', compact('planes'));
    }
}
