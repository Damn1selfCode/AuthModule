<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CodigoRefererido extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generar_CodigoReferido(Request $request)
    {
        $User = User::where('email', '=', $request->input('correo'))->first();
        $codigoIngresado = $request->input('codigoreferido');
        $codigoInterno = strtoupper(substr($User->name, 0, 2));

        DB::table('codigo_referido')->insert([
            'user_id' => $User->id,
            'created_at' => Carbon::now(),
            'codigoprivado' => $codigoIngresado,
            'codigopublico' => $codigoInterno,
        ]);

        return redirect(route('usuarios'))->with('success', 'Se genero correctamente el codigo de Referido.');
    }
    public function actualizar_CodigoReferido(Request $request)
    {
        $User = User::where('email', '=', $request->input('correo'))->first();
        $codigoIngresado = $request->input('codigoreferido');

        DB::table('codigo_referido')
            ->where('user_id', $User->id)
            ->update([
                'codigoprivado' => $codigoIngresado,
                'updated_at' => Carbon::now(),
            ]);

        return redirect(route('usuarios'))->with('success', 'Se actualizo correctamente el codigo de Referido.');
    }
}
