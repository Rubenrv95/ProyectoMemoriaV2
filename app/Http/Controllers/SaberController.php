<?php

namespace App\Http\Controllers;

use App\Models\Saber;
use App\Models\Aprendizaje;
use App\Models\Competencia;
use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Datatables;

class SaberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_carrera, $id_plan, Request $request)
    {
        $request->validate([
            'desc_saber'=>'required'
        ]);


        $query = DB::table('sabers')->insert([
            'Descripcion_saber'=>$request->input('desc_saber'),
            'tipo_saber'=>$request->input('tipo_saber'),
            'refAprendizaje'=>$request->input('refAprend'),
            'refPlan'=>$id_plan,
        ]);

        return back()->withSuccess('Saber creado con éxito');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Saber  $saber
     * @return \Illuminate\Http\Response
     */
    public function show(Saber $saber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Saber  $saber
     * @return \Illuminate\Http\Response
     */
    public function edit(Saber $saber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Saber  $saber
     * @return \Illuminate\Http\Response
     */
    public function update($id_carrera, $id_plan, Request $request, $id_saber)
    {
        $request->validate([
            'desc_saber'=>'required'
        ]);


        $query = DB::table('sabers')->where('id', $id_saber)->update([
            'Descripcion_saber'=>$request->input('desc_saber'),
            'tipo_saber'=>$request->input('tipo_saber'),
            'refAprendizaje'=>$request->input('refAprend'),
        ]);

        return back()->withSuccess('Saber actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Saber  $saber
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_carrera, $id_plan, $id_saber)
    {
        $query = DB::table('sabers')->where('id', $id_saber)->delete();
        
        return back()->withSuccess('Saber eliminado con éxito');
    }
}
