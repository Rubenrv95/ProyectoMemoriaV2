<?php

namespace App\Http\Controllers;

use App\Models\Dimension;
use App\Models\Competencia;
use Illuminate\Http\Request;
use App\Models\Carrera;
use Illuminate\Support\Facades\DB;
use Datatables;



class DimensionController extends Controller
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
        $dimension = DB::table('dimensions')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('dimensions.*', 'competencias.Descripcion', 'competencias.Orden as Orden_comp', 'competencias.id as idComp' )->get();
        $competencia = json_decode($competencia, true);
        $dimension = json_decode($dimension, true);

        return view('carreras.dimensiones')->with('carrera', $carrera)->with('competencia', $competencia)->with('dimension', $dimension);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_carrera, Request $request)
    {
        $request->validate([
            'desc_dimension'=>'required',
            'orden_dimension'=>'required',
        ]);


        $query = DB::table('dimensions')->insert([
            'Descripcion_dimension'=>$request->input('desc_dimension'),
            'Orden'=>$request->input('orden_dimension'),
            'refCompetencia'=>$request->input('refComp'),
        ]);

        return back()->withSuccess('Dimensión creada con éxito');
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
     * @param  \App\Models\Dimension  $dimension
     * @return \Illuminate\Http\Response
     */
    public function show(Dimension $dimension)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dimension  $dimension
     * @return \Illuminate\Http\Response
     */
    public function edit(Dimension $dimension)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dimension  $dimension
     * @return \Illuminate\Http\Response
     */
    public function update($id_carrera, Request $request, $id_dim)
    {
        $request->validate([
            'desc_dimension'=>'required',
            'orden_dimension'=>'required',
        ]);


        $query = DB::table('dimensions')->where('id', $id_dim)->update([
            'Descripcion_dimension'=>$request->input('desc_dimension'),
            'Orden'=>$request->input('orden_dimension'),
            'refCompetencia'=>$request->input('refComp'),
        ]);

        $dimension = Dimension::find($id_dim);
        $dimension -> touch();

        return back()->withSuccess('Dimensión actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dimension  $dimension
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_carrera, $id_dim)
    {
        $query = DB::table('dimensions')->where('id', $id_dim)->delete();

        $query2= 'DELETE aprendizajes, saberes, propuesta_modulos, propuesta_tiene_saber FROM aprendizajes 
        INNER JOIN saberes ON saberes.refAprendizaje = aprendizajes.id
        INNER JOIN propuesta_tiene_saber ON saberes.id = propuesta_tiene_saber.saber
        INNER JOIN propuesta_modulos  ON  propuesta_tiene_saber.propuesta_modulo = propuesta_modulos.id
        WHERE aprendizajes.refDimension = ?';

        $status = \DB::delete($query2, array($id_dim));
        
        return back()->withSuccess('Dimensión eliminada con éxito');
    }
}
