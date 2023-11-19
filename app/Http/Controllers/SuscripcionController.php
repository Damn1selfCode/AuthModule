<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SuscripcionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($codigo)
    {

        $planesPaypal = DB::table('subscriptions')
            ->where('user_id', $codigo)
            ->latest('created_at')
            ->first();

        return $planesPaypal;
    }
}
