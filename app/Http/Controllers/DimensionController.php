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
     * Se muestra la vista de dimensiones
     */
    public function index($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);
        $competencia = DB::table('competencias')->where('refcarrera', $id_carrera)->orderBy('orden')->get();
        $dimension = DB::table('dimensions')
        ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
        ->where('competencias.refcarrera', '=', $id_carrera)
        ->select('dimensions.*', 'competencias.descripcion', 'competencias.orden as Orden_comp', 'competencias.id as idComp' )
        ->get();
        $competencia = json_decode($competencia, true);
        $dimension = json_decode($dimension, true);

        return view('carreras.dimensiones')->with('carrera', $carrera)->with('competencia', $competencia)->with('dimension', $dimension);
    }

    /**
     * Se crea una dimensión
     */
    public function create($id_carrera, Request $request)
    {
        $request->validate([
            'desc_dimension'=>'required',
            'orden_dimension'=>'required',
        ]);


        $query = DB::table('dimensions')->insert([
            'descripcion_dimension'=>$request->input('desc_dimension'),
            'orden'=>$request->input('orden_dimension'),
            'refcompetencia'=>$request->input('refComp'),
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
     * Se actualiza una dimensión
     */
    public function update($id_carrera, Request $request, $id_dim)
    {
        $request->validate([
            'desc_dimension'=>'required',
            'orden_dimension'=>'required',
        ]);


        $query = DB::table('dimensions')->where('id', $id_dim)->update([
            'descripcion_dimension'=>$request->input('desc_dimension'),
            'orden'=>$request->input('orden_dimension'),
            'refcompetencia'=>$request->input('refComp'),
        ]);

        $dimension = Dimension::find($id_dim);
        $dimension -> touch();

        return back()->withSuccess('Dimensión actualizada con éxito');
    }

    /**
     * Se borra una dimensión
     * @param id_carrera, id de la carrera
     * @param id_dim, id de la dimensión
     */
    public function destroy($id_carrera, $id_dim)
    {
        $query= 'DELETE aprendizajes, sabers, propuesta_modulos, propuesta_tiene_saber FROM aprendizajes 
        INNER JOIN sabers ON sabers.refaprendizaje = aprendizajes.id
        INNER JOIN propuesta_tiene_saber ON sabers.id = propuesta_tiene_saber.saber
        INNER JOIN propuesta_modulos ON propuesta_tiene_saber.propuesta_modulo = propuesta_modulos.id
        WHERE aprendizajes.refdimension = ?';

        $status = \DB::delete($query, array($id_dim));

        $query2 = DB::table('dimensions')->where('id', $id_dim)->delete();

        return back()->withSuccess('Dimensión eliminada con éxito');
    }
}
