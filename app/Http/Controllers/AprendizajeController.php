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
    public function index($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);
        $competencia = DB::table('competencias')->where('refCarrera', $id_carrera)->get();
        $aprendizaje = DB::table('aprendizajes')->leftJoin('competencias', 'aprendizajes.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('aprendizajes.*', 'competencias.Descripcion', 'competencias.Orden')->get();
        $saber = DB::table('saber_conocers')->leftJoin('aprendizajes', 'saber_conocers.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('competencias', 'aprendizajes.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('saber_conocers.*', 'aprendizajes.Descripcion_aprendizaje', 'competencias.refCarrera')->get();
        $competencia = json_decode($competencia, true);
        $aprendizaje = json_decode($aprendizaje, true);
        $saber = json_decode($saber, true);
        return view('carreras.aprendizajes')->with('carrera', $carrera)->with('competencia', $competencia)->with('aprendizaje', $aprendizaje)->with('saber', $saber);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_carrera, Request $request)
    {
        $request->validate([
            'desc_aprendizaje'=>'required'
        ]);


        $query = DB::table('aprendizajes')->insert([
            'Descripcion_aprendizaje'=>$request->input('desc_aprendizaje'),
            'refCompetencia'=>$request->input('refComp'),
            'refCarrera'=>$id_carrera,
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
    public function show($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);
        $competencia = DB::table('competencias')->where('refCarrera', $id_carrera)->get();
        $aprendizaje = DB::table('aprendizajes')->leftJoin('competencias', 'aprendizajes.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('aprendizajes.*', 'competencias.Descripcion', 'competencias.Orden')->get();
        $competencia = json_decode($competencia, true);
        $aprendizaje = json_decode($aprendizaje, true);
        return view('carreras.tempo_aprendizajes')->with('carrera', $carrera)->with('competencia', $competencia)->with('aprendizaje', $aprendizaje);

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
    public function update($id_carrera, Request $request, $id_aprend)
    {
        $request->validate([
            'desc_aprendizaje'=>'required'
        ]);


        $query = DB::table('aprendizajes')->where('id', $id_aprend)->update([
            'Descripcion_aprendizaje'=>$request->input('desc_aprendizaje'),
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
    public function destroy($id_carrera, $id_aprend)
    {
        $query = DB::table('aprendizajes')->where('id', $id_aprend)->delete();
        
        return back()->withSuccess('Aprendizaje eliminado con éxito');
    }
}
