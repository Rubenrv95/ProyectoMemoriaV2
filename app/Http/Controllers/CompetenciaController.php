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
        $competencia = json_decode($competencia, true);
        return view('carreras.competencias')->with('carrera', $carrera)->with('competencia', $competencia);
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
        $competencia = json_decode($competencia, true);
        return view('carreras.tempo_competencias')->with('carrera', $carrera)->with('competencia', $competencia);

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

        $query2= 'DELETE dimensions, aprendizajes, saberes, propuesta_modulos, propuesta_tiene_saber FROM dimensions 
          INNER JOIN aprendizajes ON aprendizajes.refDimension = dimensions.id
          INNER JOIN saberes ON saberes.refAprendizaje = aprendizajes.id
          INNER JOIN propuesta_tiene_saber ON saberes.id = propuesta_tiene_saber.saber
          INNER JOIN propuesta_modulos  ON  propuesta_tiene_saber.propuesta_modulo = propuesta_modulos.id
          WHERE dimensions.refCompetencia = ?';

        $status = \DB::delete($query2, array($id_comp));
        
        return back()->withSuccess('Competencia eliminada con éxito');
    }
}
