<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Se muestra la vista de usuarios
     */
    public function index()
    {
        $data = User::orderBy('nombre')->where('nombre', '<>', 'Administrador')->get(); 

        if (Auth::user()->rol == 'Administrador') {
            return view ('/usuarios', ['user'=>$data]);
        }
        else {
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Se crea y almacena un usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|string',
            'email'=>'required|string|email',
            'password'  =>  'required|alphaNum|min:6|confirmed',
            'password_confirmation'  => ['same:password'],
        ]);

        $user = User::where('email', '=', $request->input('email'))->first();

        if ($user === null) {
            $query = DB::table('users')->insert([
                'nombre'=>$request->input('nombre'),
                'email'=>$request->input('email'),
                'rol'=>$request->input('rol'),
                'password' => Hash::make($request->input('password')),
                'remember_token' => Str::random(10)
            ]);
    
            return back()->withSuccess('Usuario creado con éxito');
        }

        else {
            return back()->withErrors('El correo electrónico ingresado ya existe en la base de datos');
        }

        return back()->withErrors('El correo electrónico ingresado ya existe en la base de datos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Se actualiza un usuario
     * @param id del usuario
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'=>'required|string',
            'email'=>'required|string|email'
        ]);


        $query = DB::table('users')->where('id', $id)->update([
            'nombre'=>$request->input('nombre'),
            'email'=>$request->input('email'),
            'rol'=>$request->input('rol'),
        ]);
        

        return back()->withSuccess('Datos de usuario actualizados con éxito');
    }

    /**
     * Se elimina un usuario
     * @param id del usuario
     */
    public function destroy($id)
    {
        $query = DB::table('users')->where('id', $id)->delete();
        
        return back()->withSuccess('Usuario eliminado con éxito');
    }
}
