<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use Illuminate\Http\Request;
use App\Models\Carrera;
use Illuminate\Support\Facades\DB;
use Datatables;

class CompetenciaController extends Controller
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
        $competencia = json_decode($competencia, true);
        $aprendizaje = json_decode($aprendizaje, true);
        return view('carreras.competencias')->with('carrera', $carrera)->with('competencia', $competencia)->with('aprendizaje', $aprendizaje);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_carrera, Request $request)
    {
        $request->validate([
            'desc_competencia'=>'required',
            'orden_competencia'=>'required',
        ]);


        $query = DB::table('competencias')->insert([
            'Descripcion'=>$request->input('desc_competencia'),
            'Orden'=>$request->input('orden_competencia'),
            'refCarrera'=>$id_carrera,
        ]);

        return back()->withSuccess('Competencia creada con éxito');
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
     * @param  \App\Models\Competencia  $competencia
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
        return view('carreras.tempo_competencias')->with('carrera', $carrera)->with('competencia', $competencia)->with('aprendizaje', $aprendizaje);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Competencia  $competencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Competencia $competencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Competencia  $competencia
     * @return \Illuminate\Http\Response
     */
    public function update($id_carrera, Request $request, $id_comp)
    {
        $request->validate([
            'desc_competencia'=>'required',
            'orden_competencia'=>'required',
        ]);


        $query = DB::table('competencias')->where('id', $id_comp)->update([
            'Descripcion'=>$request->input('desc_competencia'),
            'Orden'=>$request->input('orden_competencia'),
        ]);

        $competencia = Competencia::find($id_comp);
        $competencia -> touch();

        return back()->withSuccess('Competencia actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Competencia  $competencia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $id_comp)
    {
        $query = DB::table('competencias')->where('id', $id_comp)->delete();
        $query2 = DB::table('dimensions')->where('refCompetencia', $id_comp)->delete();
        $query3 = DB::table('aprendizajes')->where('refCompetencia', $id_comp)->delete();
        
        return back()->withSuccess('Competencia eliminada con éxito');
    }
}
