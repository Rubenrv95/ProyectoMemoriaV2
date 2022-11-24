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
     * Se muestra la vista inicial
     */
    public function index()
    {
        $carreras = DB::table('carreras')->where('formacion', 'Profesional')->get();
        $carreras2 = DB::table('carreras')->where('formacion', 'Técnica')->get();
        $usuarios = DB::table('users')->where('nombre', '<>', 'Administrador')->get();

        $cant_1 = $carreras->count();
        $cant_2 = $carreras2->count();
        $cant_3 = $usuarios->count();

        return view('home')->with('carreras', $cant_1)->with('tecnicas', $cant_2)->with('usuarios', $cant_3);
    }
}
