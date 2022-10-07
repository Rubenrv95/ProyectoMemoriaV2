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
        
        $aprendizaje = DB::table('aprendizajes')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('aprendizajes.*')->get();
        $saber = DB::table('saberes')->leftJoin('aprendizajes', 'saberes.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('saberes.*', 'aprendizajes.Descripcion_aprendizaje', 'aprendizajes.id as idAprend', 'dimensions.Descripcion_dimension', 'dimensions.Orden as OrdenDim', 'competencias.Orden as OrdenComp', 'competencias.Descripcion')->get();
        
        $aprendizaje = json_decode($aprendizaje, true);
        $saber = json_decode($saber, true);

        return view('carreras.saberes')->with('carrera', $carrera)->with('aprendizaje', $aprendizaje)->with('saber', $saber);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_carrera, Request $request)
    {
        $request->validate([
            'desc-saber'=>'required'
        ]);


        $query = DB::table('saberes')->insert([
            'Descripcion_saber'=>$request->input('desc-saber'),
            'Tipo'=>$request->input('tipo'),
            'Nivel'=>$request->input('nivel'),
            'refAprendizaje'=>$request->input('refAprend'),
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
    public function show($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);

        $saber = DB::table('saberes')->leftJoin('aprendizajes', 'saberes.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('saberes.*', 'aprendizajes.Descripcion_aprendizaje', 'dimensions.Descripcion_dimension', 'dimensions.Orden as OrdenDim', 'competencias.Orden as OrdenComp', 'competencias.Descripcion')->get();
        $saber = json_decode($saber, true);

        return view('carreras.ver_saberes')->with('carrera', $carrera)->with('saber', $saber);
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
    public function update($id_carrera, Request $request, $id_saber)
    {
        $request->validate([
            'desc-saber'=>'required'
        ]);


        $query = DB::table('saberes')->where('id', $id_saber)->update([
            'Descripcion_saber'=>$request->input('desc-saber'),
            'Tipo'=>$request->input('tipo'),
            'Nivel'=>$request->input('nivel'),
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
    public function destroy($id_carrera, $id_saber)
    {
        $query = DB::table('saberes')->where('id', $id_saber)->delete();
        
        return back()->withSuccess('Saber eliminado con éxito');
    }
}
