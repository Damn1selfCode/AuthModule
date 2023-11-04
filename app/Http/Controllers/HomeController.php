<?php

namespace App\Http\Controllers;

use App\Services\PaypalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        //no se autodestruye la cache hasta hacerlo manual
        // $planesPaypal = Cache::rememberForever('keyPlanes', function () {
        //     return $this->planes();
        // });

        $planesPaypal = Cache::remember('planes', 60, function () {
            return $this->planes();
        });



        return view('welcome', compact('planesPaypal',));
    }


    private function planes()
    {
        $servicio  = new  PaypalService;
        $data = $servicio->ListarPlanes();
        $planesPaypal = $data['plans'];
        return $planesPaypal;
    }
}
