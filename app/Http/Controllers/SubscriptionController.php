<?php

namespace App\Http\Controllers;

use App\Models\Plan;
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


        $User = User::where('email', '=', $request->input('correo'))->first();

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



        DB::table('subscriptions')->insert([
            'active_until' => Carbon::now()->addMonths($Plan->duration_in_month),
            'user_id' => $User->id,
            'big_user_id' => null,
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

        return redirect($urlAprobacion); //->back()->with('success', 'Usuario suscrito correctamente.Realice el pago para finalizar.');
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
