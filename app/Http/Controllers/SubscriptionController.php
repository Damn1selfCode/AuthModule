<?php

namespace App\Http\Controllers;

use App\Models\CodigoReferido;
use App\Models\Plan;
use App\Models\Suscripciones;
use App\Models\User;
use App\Services\PaypalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

class SubscriptionController extends Controller
{
    //usuario autenticado puede acceder
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function suscribirse(Request $request, PaypalService $servicio)
    {

        // try {
        //     DB::beginTransaction();
        // dd($request);

        //codigoReferido

        $codigoReferido = $request->input('codigoReferido');
        $CodRef = null;
        $CodRef2 = null;

        if ($codigoReferido != null) {
            //REFERIDO1
            $CodRef = CodigoReferido::whereRaw("CONCAT(codigoprivado, codigopublico) = ?", [$codigoReferido])->first();

            if ($CodRef == null) {
                return redirect(route('usuarios'))->with('warning', "El código {$codigoReferido} no existe!!");
            } else {
                //REFERIDO2
                $CodRef2 = Suscripciones::where("user_id", $CodRef->user_id)->latest('created_at')->first();
            }
        }


        $User = User::where('email', '=', $request->input('correo'))->first(); //SUSCRIPTOR

        $Plan = Plan::where('id_plan_paypal', '=', $request->input('codigoPlan'))->first();

        // if (!$User || !$Plan) {
        //     DB::rollBack();
        //     return redirect()->back()->with('error', 'Usuario o plan no encontrado.');
        // }
        $data = $servicio->Suscribirse($Plan->id_plan_paypal, $User);


        if (isset($data['links'])) {
            foreach ($data['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    $urlAprobacion = $link['href'];
                }
            }
        }


        if ($CodRef2 == null && $CodRef == null) {
            DB::table('compensacion')->insert([
                'user_id_origen' => $User->id, //origen
                'user_id_destino' => 1, //compensado LEARN STREAM
                'monto' => $Plan->price,
                'fecha_compensacion' => Carbon::now(),
            ]);
        } elseif ($CodRef2->big_user_id == 1 && $CodRef != null) {
            DB::table('compensacion')->insert([
                'user_id_origen' => $User->id, //origen
                'user_id_destino' => 1, //compensado LEARN STREAM
                'monto' => ($Plan->price) * 0.80,
                'fecha_compensacion' => Carbon::now(),
            ]);
            DB::table('compensacion')->insert([
                'user_id_origen' => $User->id, //origen
                'user_id_destino' => $CodRef->user_id, //compensado 1ER BENEFICIARIO
                'monto' => ($Plan->price) * 0.20,
                'fecha_compensacion' => Carbon::now(),
            ]);
        } else {
            DB::table('compensacion')->insert([
                'user_id_origen' => $User->id, //origen
                'user_id_destino' => 1, //compensado LEARN STREAM
                'monto' => ($Plan->price) * 0.75,
                'fecha_compensacion' => Carbon::now(),
            ]);
            DB::table('compensacion')->insert([
                'user_id_origen' => $User->id, //origen
                'user_id_destino' => $CodRef->user_id, //compensado 1ER BENEFICIARIO
                'monto' => ($Plan->price) * 0.20,
                'fecha_compensacion' => Carbon::now(),
            ]);
            DB::table('compensacion')->insert([
                'user_id_origen' => $User->id, //origen
                'user_id_destino' => $CodRef2->big_user_id, //compensado 2ER BENEFICIARIO
                'monto' => ($Plan->price) * 0.05,
                'fecha_compensacion' => Carbon::now(),
            ]);
        }




        DB::table('subscriptions')->insert([
            'active_until' => Carbon::now()->addMonths($Plan->duration_in_month),
            'user_id' => $User->id,
            'big_user_id' => $codigoReferido == null ? 1 : $CodRef->user_id, //usuario 1 es LEARNSTREAM
            'plan_id' => $Plan->id,
            'created_at' => Carbon::now(),
            'plan_id_paypal' => $data['id'],
        ]);


        $Sub = DB::table('suscripcion')
            ->where('user_id', '=', $User->id)->first();

        if ($Sub === null) {
            DB::table('suscripcion')->insert([
                'user_id' => $User->id,
                'suscripcion' => 1,
                'created_at' => Carbon::now()
            ]);
        } else {
            DB::table('suscripcion')
                ->where('user_id', $User->id)
                ->update([
                    'suscripcion' => 1,
                    'updated_at' => Carbon::now(),
                ]);
        }

        // DB::commit();

        return redirect($urlAprobacion)->with('success', 'Usuario suscrito correctamente.Realice el pago para finalizar.');
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     Log::error($e->getMessage());
        //     return redirect()->back()->with('error', 'Error durante la suscripción.');
        // }
    }

    public function desuscribirse(Request $request, PaypalService $servicio)
    {


        $User = User::where('email', '=', $request->input('correo'))->first();

        $Sub = DB::table('subscriptions')
            ->where('user_id', $User->id)
            ->whereNull('fecha_cancelacion')
            ->latest('active_until')
            ->first();

        $data = $servicio->Desuscribirse($Sub->plan_id_paypal);

        DB::table('subscriptions')
            ->where('plan_id_paypal', $Sub->plan_id_paypal)
            ->where('user_id', $User->id)
            ->update([
                'fecha_cancelacion' => Carbon::now(),
            ]);

        DB::table('suscripcion')
            ->where('user_id', $User->id)
            ->update([
                'suscripcion' => 0,
                'updated_at' => Carbon::now(),
            ]);

        return redirect(route('usuarios')); //->back()->with('success', 'Usuario suscrito correctamente.Realice el pago para finalizar.');
    }
}
