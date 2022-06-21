<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Carrera;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;

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
        $planes = DB::table('plans')->get();
        $carreras = DB::table('carreras')->get();
        $usuarios = DB::table('users')->where('nombre', '<>', 'Administrador')->get();

        $cant_1 = $carreras->count();
        $cant_2 = $planes->count();
        $cant_3 = $usuarios->count();

        return view('home')->with('planes', $cant_2)->with('carreras', $cant_1)->with('usuarios', $cant_3);
    }
}
