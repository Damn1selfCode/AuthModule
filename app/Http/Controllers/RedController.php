<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedController extends Controller
{
    public function MiRed()
    {

        $user = auth()->user();
        // dd($user->id);
        $Nivel0 = DB::table('subscriptions')
            ->leftJoin('users', 'subscriptions.user_id', '=', 'users.id')
            ->where('subscriptions.user_id', '=', $user->id)
            ->select(
                'users.id as id_hijo',
                'users.name',
                'users.email',
                DB::raw('null as id_padre'),
                'subscriptions.plan_id',
                'subscriptions.plan_id_paypal'
            )
            ->get();
        $Nivel1 = DB::table('subscriptions')
            ->leftJoin('users', 'subscriptions.user_id', '=', 'users.id')
            ->where('subscriptions.big_user_id', '=', $user->id)
            ->select(
                'users.id as id_hijo',
                'users.name',
                'users.email',
                'subscriptions.big_user_id as id_padre',
                'subscriptions.plan_id',
                'subscriptions.plan_id_paypal'
            )
            ->get();

        $Nivel2 = DB::table('subscriptions')
            ->leftJoin('users', 'subscriptions.user_id', '=', 'users.id')
            ->whereIn('big_user_id', $Nivel1->pluck('id_hijo'))
            ->select(
                'users.id as id_hijo',
                'users.name',
                'users.email',
                'subscriptions.big_user_id as id_padre',
                'subscriptions.plan_id',
                'subscriptions.plan_id_paypal'
            )
            ->get();


        $resultadoFinal = collect([$Nivel0, $Nivel1, $Nivel2])->collapse();
        //dd($resultadoFinal);
        $mired = $this->construirRed($resultadoFinal);
        $tree = [
            'name' => 'Raíz',
            'image_url' => 'https://example.com/root-image.jpg',
            'code' => 'R001',
            'children' => [
                [
                    'name' => 'Hijo 1',
                    'image_url' => 'https://example.com/child1-image.jpg',
                    'code' => 'C001',
                    'children' => [
                        [
                            'name' => 'Nieto 1',
                            'image_url' => 'https://example.com/grandchild1-image.jpg',
                            'code' => 'GC001',
                        ],
                        [
                            'name' => 'Nieto 2',
                            'image_url' => 'https://example.com/grandchild2-image.jpg',
                            'code' => 'GC002',
                        ],
                    ],
                ],
                [
                    'name' => 'Hijo 2',
                    'image_url' => 'https://example.com/child2-image.jpg',
                    'code' => 'C002',
                    'children' => [
                        [
                            'name' => 'Nieto 3',
                            'image_url' => 'https://example.com/grandchild3-image.jpg',
                            'code' => 'GC003',
                        ],
                        [
                            'name' => 'Nieto 4',
                            'image_url' => 'https://example.com/grandchild4-image.jpg',
                            'code' => 'GC004',
                        ],
                        [
                            'name' => 'Nieto 55',
                            'image_url' => 'https://example.com/grandchild3-image.jpg',
                            'code' => 'GC003',
                        ],
                        [
                            'name' => 'Nieto 64',
                            'image_url' => 'https://example.com/grandchild4-image.jpg',
                            'code' => 'GC004',
                        ],
                    ],
                ],
            ],
        ];
        //dd($tree);
        $miArra = $mired[0];
        //dd($tree, $mired, $miArra);
        return view('mired', ['tree' => $miArra]);
    }

    private function construirArbol($nodos, $idPadre = null)
    {
        $arbol = [];

        foreach ($nodos as $nodo) {
            if ($nodo->id_padre == $idPadre) {
                $nodo->children = $this->construirArbol($nodos, $nodo->id_hijo);

                $arbol[] = $nodo;
            }
        }

        return $arbol;
    }

    private function construirRed($nodos, $idPadre = null)
    {
        $arbol = [];

        foreach ($nodos as $nodo) {
            if ($nodo->id_padre == $idPadre) {
                $hijo = [
                    'name' => $nodo->name,
                    'id_hijo' => $nodo->id_hijo,
                    'name' => $nodo->name,
                    'email' => $nodo->email,
                    'id_padre' => $nodo->id_padre,
                    'plan_id' => $nodo->plan_id,
                    'plan_id_paypal' => $nodo->plan_id_paypal,
                    'image_url' => "https://icon-library.com/images/admin-user-icon/admin-user-icon-24.jpg",
                    'children' => $this->construirRed($nodos, $nodo->id_hijo),
                ];

                $arbol[] = $hijo;
            }
        }

        return $arbol;
    }
}
