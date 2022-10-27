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
        
        $aprendizaje = DB::table('aprendizajes')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('aprendizajes.*')->get();
        $saber = DB::table('sabers')->leftJoin('aprendizajes', 'sabers.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('sabers.*', 'aprendizajes.Descripcion_aprendizaje', 'aprendizajes.id as idAprend', 'dimensions.Descripcion_dimension', 'dimensions.Orden as OrdenDim', 'competencias.Orden as OrdenComp', 'competencias.Descripcion')->get();
        
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
     * Se muestra la tabla de saberes
     * @param id_carrera, id de la carrera
     */
    public function show($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);

        $saber = DB::table('sabers')->leftJoin('aprendizajes', 'sabers.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('sabers.*', 'aprendizajes.Descripcion_aprendizaje', 'dimensions.Descripcion_dimension', 'dimensions.Orden as OrdenDim', 'competencias.Orden as OrdenComp', 'competencias.Descripcion')->get();
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
            'Descripcion_saber'=>$request->input('desc-saber'),
            'Tipo'=>$request->input('tipo'),
            'Nivel'=>$request->input('nivel'),
            'refAprendizaje'=>$request->input('refAprend'),
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
        $query = DB::table('sabers')->where('id', $id_saber)->delete();

        $query2= 'DELETE propuesta_modulos, propuesta_tiene_saber, modulos, modulo_tiene_prerrequisito FROM propuesta_modulos
        INNER JOIN propuesta_tiene_saber  ON  propuesta_tiene_saber.propuesta_modulo = propuesta_modulos.id
        INNER JOIN modulos  ON  propuesta_modulos.id = modulos.refPropuesta
        INNER JOIN modulo_tiene_prerrequisito  ON  modulo.id = modulo_tiene_prerrequisito.modulo
        WHERE propuesta_tiene_saber.saber = ?';

        $status = \DB::delete($query2, array($id_saber));
        
        return back()->withSuccess('Saber eliminado con éxito');
    }
}
