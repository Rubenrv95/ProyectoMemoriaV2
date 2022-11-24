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
     * Vista de saberes
     * @param id_carrera, id de la carrera
     */
    public function index($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);
        
        $aprendizaje = DB::table('aprendizajes')
        ->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
        ->where('competencias.refcarrera', '=', $id_carrera)
        ->orderBy('aprendizajes.nivel_aprend')
        ->select('aprendizajes.*')
        ->get();
        $saber = DB::table('sabers')
        ->leftJoin('aprendizajes', 'sabers.refaprendizaje', '=', 'aprendizajes.id')
        ->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
        ->where('competencias.refCarrera', '=', $id_carrera)
        ->select('sabers.*', 'aprendizajes.descripcion_aprendizaje', 'aprendizajes.id as idAprend', 'dimensions.descripcion_dimension', 'dimensions.orden as OrdenDim', 'competencias.orden as OrdenComp', 'competencias.descripcion')
        ->get();
        
        $aprendizaje = json_decode($aprendizaje, true);
        $saber = json_decode($saber, true);

        return view('carreras.saberes')->with('carrera', $carrera)->with('aprendizaje', $aprendizaje)->with('saber', $saber);
    }

    /**
     * Se crea un saber
     * @param id_carrera, id de la carrera
     */
    public function create($id_carrera, Request $request)
    {
        $request->validate([
            'desc-saber'=>'required'
        ]);


        $query = DB::table('sabers')->insert([
            'descripcion_saber'=>$request->input('desc-saber'),
            'tipo'=>$request->input('tipo'),
            'nivel'=>$request->input('nivel'),
            'refaprendizaje'=>$request->input('refAprend'),
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
     * Se muestra la tabla de saberes
     * @param id_carrera, id de la carrera
     */
    public function show($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);

        $saber = DB::table('sabers')
        ->leftJoin('aprendizajes', 'sabers.refaprendizaje', '=', 'aprendizajes.id')
        ->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
        ->where('competencias.refcarrera', '=', $id_carrera)
        ->select('sabers.*', 'aprendizajes.descripcion_aprendizaje', 'dimensions.descripcion_dimension', 'dimensions.orden as OrdenDim', 'competencias.orden as OrdenComp', 'competencias.descripcion')
        ->get();
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
     * Se actualiza un saber
     * @param id_carrera, id de la carrera
     * @param id_saber, id del saber seleccionado
     */
    public function update($id_carrera, Request $request, $id_saber)
    {
        $request->validate([
            'desc-saber'=>'required'
        ]);


        $query = DB::table('sabers')->where('id', $id_saber)->update([
            'descripcion_saber'=>$request->input('desc-saber'),
            'tipo'=>$request->input('tipo'),
            'nivel'=>$request->input('nivel'),
            'refaprendizaje'=>$request->input('refAprend'),
        ]);

        $saber = Saber::find($id_saber);
        $saber -> touch();

        return back()->withSuccess('Saber actualizado con éxito');
    }

    /**
     * Se elimina un saber
     * @param id_carrera, id de la carrera
     * @param id_saber, id del saber seleccionado
     */
    public function destroy($id_carrera, $id_saber)
    {  
        $query= 'DELETE propuesta_modulos, propuesta_tiene_saber FROM propuesta_modulos
        INNER JOIN propuesta_tiene_saber ON propuesta_tiene_saber.propuesta_modulo = propuesta_modulos.id
        WHERE propuesta_tiene_saber.saber = ?';

        $status = \DB::delete($query, array($id_saber));

        $query2 = DB::table('sabers')->where('id', $id_saber)->delete();

        
        return back()->withSuccess('Saber eliminado con éxito');
    }
}
