<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PaypalService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //usuario autenticado puede acceder
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function suscribirse(Request $request, PaypalService $servicio)
    {

        $user = new User([
            'name' => $request->input('nombres'),
            'email' => $request->input('correo')
        ]);

        $data = $servicio->Suscribirse($request->input('codigoPlan'), $user);
        return redirect($data); //->back()->with('success', 'Usuario suscrito correctamente.Realice el pago para finalizar.');
    }
}
