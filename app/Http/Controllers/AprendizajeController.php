<?php

namespace App\Http\Controllers;

use App\Models\Aprendizaje;
use App\Models\Competencia;
use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Datatables;

class AprendizajeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
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
            'desc_aprendizaje'=>'required'
        ]);


        $query = DB::table('aprendizajes')->insert([
            'Descripcion_aprendizaje'=>$request->input('desc_aprendizaje'),
            'tipo_aprendizaje'=>$request->input('tipo_aprend'),
            'refCompetencia'=>$request->input('refComp'),
            'refPlan'=>$id_plan,
        ]);

        return back()->withSuccess('Aprendizaje creado con éxito');
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
     * @param  \App\Models\Aprendizaje  $aprendizaje
     * @return \Illuminate\Http\Response
     */
    public function show(Aprendizaje $aprendizaje)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aprendizaje  $aprendizaje
     * @return \Illuminate\Http\Response
     */
    public function edit(Aprendizaje $aprendizaje)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aprendizaje  $aprendizaje
     * @return \Illuminate\Http\Response
     */
    public function update($id_carrera, $id_plan, Request $request, $id_aprend)
    {
        $request->validate([
            'desc_aprendizaje'=>'required'
        ]);


        $query = DB::table('aprendizajes')->where('id', $id_aprend)->update([
            'Descripcion_aprendizaje'=>$request->input('desc_aprendizaje'),
            'tipo_aprendizaje'=>$request->input('tipo_aprend'),
            'refCompetencia'=>$request->input('refComp'),
        ]);

        return back()->withSuccess('Aprendizaje actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aprendizaje  $aprendizaje
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_carrera, $id_plan, $id_aprend)
    {
        $query = DB::table('aprendizajes')->where('id', $id_aprend)->delete();
        
        return back()->withSuccess('Aprendizaje eliminado con éxito');
    }
}
