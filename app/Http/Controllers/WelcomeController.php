<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PlanSubs\PlanSubsController;
use App\Services\PaypalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{

    public function index()
    {
        //no se autodestruye la cache hasta hacerlo manual
        // $planesPaypal = Cache::rememberForever('keyPlanes', function () {
        //     return $this->planes();
        // });

        $planesPaypal = Cache::remember('planes', 60, function () {
            return $this->planes();
        });
        return view('welcome', compact('planesPaypal'));
    }

    public function planes()
    {
        $servicio  = new  PaypalService;
        $data = $servicio->ListarPlanes();
        $planesPaypal = $data['plans'];
        return $planesPaypal;
    }
}
