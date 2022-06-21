<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Datatables;


class ChangePasswordController extends Controller
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
        
    } 
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'contraseña_actual' => ['required', new MatchOldPassword],
            'contraseña_nueva' => ['required'],
            'confirmar_contraseña' => ['same:contraseña_nueva'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->contraseña_nueva)]);
   
        return back()->withSuccess('Contraseña cambiada con éxito');
    }
}
