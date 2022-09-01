<?php

namespace App\Http\Controllers;

use App\Models\Dimension;
use App\Models\Competencia;
use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Plan;
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
    public function index($id_carrera, $id_plan)
    {
        $plan = DB::table('plans')->where('id', $id_plan)->get();
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $plan = json_decode($plan, true);
        $carrera = json_decode($carrera, true);
        $competencia = DB::table('competencias')->where('refPlan', $id_plan)->get();
        $dimension = DB::table('dimensions')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refPlan', '=', $id_plan)->select('dimensions.*', 'competencias.Descripcion', 'competencias.Orden', 'competencias.id as idComp' )->get();
        $competencia = json_decode($competencia, true);
        $dimension = json_decode($dimension, true);

        return view('planes.dimensiones')->with('plan', $plan)->with('carrera', $carrera)->with('competencia', $competencia)->with('dimension', $dimension);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_carrera, $id_plan, Request $request)
    {
        $request->validate([
            'desc_dimension'=>'required',
            'basico_dimension'=>'required',
            'desarrollo_dimension'=>'required',
            'logrado_dimension'=>'required',
        ]);


        $query = DB::table('dimensions')->insert([
            'Descripcion_dimension'=>$request->input('desc_dimension'),
            'Basico'=>$request->input('basico_dimension'),
            'En_desarrollo'=>$request->input('desarrollo_dimension'),
            'Logrado'=>$request->input('logrado_dimension'),
            'Especializacion'=>$request->input('especializado_dimension'),
            'refCompetencia'=>$request->input('refComp'),
            'refPlan'=>$id_plan,
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
    public function update($id_carrera, $id_plan, Request $request, $id_dim)
    {
        $request->validate([
            'desc_dimension'=>'required',
            'basico_dimension'=>'required',
            'desarrollo_dimension'=>'required',
            'logrado_dimension'=>'required',
        ]);


        $query = DB::table('dimensions')->where('id', $id_dim)->update([
            'Descripcion_dimension'=>$request->input('desc_dimension'),
            'Basico'=>$request->input('basico_dimension'),
            'En_desarrollo'=>$request->input('desarrollo_dimension'),
            'Logrado'=>$request->input('logrado_dimension'),
            'Especializacion'=>$request->input('especializado_dimension'),
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
    public function destroy($id_carrera, $id_plan, $id_dim)
    {
        $query = DB::table('dimensions')->where('id', $id_dim)->delete();
        
        return back()->withSuccess('Dimensión eliminada con éxito');
    }
}
