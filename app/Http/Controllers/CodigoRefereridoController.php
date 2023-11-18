<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class CodigoRefereridoController  extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generar_CodigoReferido(Request $request)
    {
        try {
            //dd($request->all()); //retorna las variables $request
            $userId = json_decode($request->input('user'), true)['id'];
            $User = User::where('id', '=', $userId)->first();

            $codigopub = $request->input('codigorefpub');
            $codigopriv = $request->input('codigorefpriv');

            $existingCode = $this->validar($codigopub, $codigopriv);

            if ($existingCode) {
                return redirect(route('usuarios'))->with('warning', "El código {$codigopriv}{$codigopub} se encuentra en uso!!");
            }

            DB::table('codigo_referido')->insert([
                'user_id' => $User->id,
                'created_at' => Carbon::now(),
                'codigoprivado' => $codigopriv,
                'codigopublico' => $codigopub,
            ]);



            return redirect(route('usuarios'))->with('success', 'Se genero correctamente el codigo de Referido.');
        } catch (QueryException $e) {
            // Manejar la excepción de la base de datos
            return redirect(route('usuarios'))->with('error', 'Error al generar el código de Referido: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Manejar otras excepciones
            return redirect(route('usuarios'))->with('error', 'Error inesperado: ' . $e->getMessage());
        }
    }
    public function actualizar_CodigoReferido(Request $request)
    {
        try {
            $userId = json_decode($request->input('user'), true)['id'];
            $User = User::where('id', '=', $userId)->first();
            $codigopub = $request->input('codigorefpub');
            $codigopriv = $request->input('codigorefpriv');


            $existingCode = $this->validar($codigopub, $codigopriv);

            if ($existingCode) {
                return redirect(route('usuarios'))->with('warning', "El código {$codigopriv}{$codigopub} se encuentra en uso!!");
            }

            DB::table('codigo_referido')
                ->where('user_id', $User->id)
                ->update([
                    'codigopublico' => $codigopub,
                    'codigoprivado' => $codigopriv,
                    'updated_at' => Carbon::now(),
                ]);

            return redirect(route('usuarios'))->with('success', 'Se actualizo correctamente el codigo de Referido.');
        } catch (QueryException $e) {
            // Manejar la excepción de la base de datos
            return redirect(route('usuarios'))->with('error', 'Error al generar el código de Referido: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Manejar otras excepciones
            return redirect(route('usuarios'))->with('error', 'Error inesperado: ' . $e->getMessage());
        }
    }

    protected function validar($codigopub, $codigopriv)
    {
        $existingCode = DB::table('codigo_referido')
            ->where('codigopublico', $codigopub)
            ->where('codigoprivado', $codigopriv)
            ->first();

        return $existingCode;
    }
}
