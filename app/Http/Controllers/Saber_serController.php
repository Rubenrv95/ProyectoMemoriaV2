<?php

namespace App\Http\Controllers;

use App\Models\Saber_ser;
use App\Models\Aprendizaje;
use App\Models\Competencia;
use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Datatables;

class Saber_serController extends Controller
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
        $plan = DB::table('plans')->where('id', $id_plan)->get();
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $plan = json_decode($plan, true);
        $carrera = json_decode($carrera, true);
        $competencia = DB::table('competencias')->where('refPlan', $id_plan)->get();
        $aprendizaje = DB::table('aprendizajes')->leftJoin('competencias', 'aprendizajes.refCompetencia', '=', 'competencias.id')->where('competencias.refPlan', '=', $id_plan)->select('aprendizajes.*', 'competencias.Descripcion')->get();
        $saber = DB::table('saber_sers')->leftJoin('aprendizajes', 'saber_sers.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('competencias', 'aprendizajes.refCompetencia', '=', 'competencias.id')->where('competencias.refPlan', '=', $id_plan)->select('saber_sers.*', 'aprendizajes.Descripcion_aprendizaje', 'competencias.refPlan')->get();
        $competencia = json_decode($competencia, true);
        $aprendizaje = json_decode($aprendizaje, true);
        $saber = json_decode($saber, true);
        return view('planes.saberes')->with('plan', $plan)->with('carrera', $carrera)->with('competencia', $competencia)->with('aprendizaje', $aprendizaje)->with('saber', $saber);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Saber_ser  $saber_ser
     * @return \Illuminate\Http\Response
     */
    public function show(Saber_ser $saber_ser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Saber_ser  $saber_ser
     * @return \Illuminate\Http\Response
     */
    public function edit(Saber_ser $saber_ser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Saber_ser  $saber_ser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Saber_ser $saber_ser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Saber_ser  $saber_ser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Saber_ser $saber_ser)
    {
        //
    }
}
