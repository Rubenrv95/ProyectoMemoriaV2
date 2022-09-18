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
        $dimension =  DB::table('dimensions')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('dimensions.*', 'competencias.Descripcion', 'competencias.Orden as OrdenComp', 'competencias.id as idComp')->get();
        $aprendizaje = DB::table('aprendizajes')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('aprendizajes.*', 'competencias.Descripcion', 'competencias.Orden as OrdenComp', 'competencias.id as idComp', 'dimensions.Descripcion_dimension', 'dimensions.Orden', 'dimensions.id as idDim')->get();
        
        $dimension = $dimension->sortByDesc('Orden');
        $aprendizaje = $aprendizaje->sortByDesc('Orden');
        
        $competencia = json_decode($competencia, true);
        $aprendizaje = json_decode($aprendizaje, true);
        $dimension = json_decode($dimension, true);
        
        return view('carreras.aprendizajes')->with('carrera', $carrera)->with('competencia', $competencia)->with('aprendizaje', $aprendizaje)->with('dimension', $dimension);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_carrera, Request $request)
    {
        $request->validate([
            'aprendizaje_desc'=>'required',
        ]);


        $query = DB::table('aprendizajes')->insert([
            'Descripcion_aprendizaje'=>$request->input('aprendizaje_desc'),
            'refCompetencia'=>$request->input('refCompCrear'),
            'refDimension'=>$request->input('dimension'),
            'Nivel_aprend'=>$request->input('nivel'),
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
    public function show($id_carrera, $id_competencia)
    {

        $dim =  DB::table('dimensions')->where('dimensions.refCompetencia', '=', $id_competencia)->get();

        return response()->json($dim);
    }

       /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aprendizaje  $aprendizaje
     * @return \Illuminate\Http\Response
     */
    public function show_Tempo($id_carrera)
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


        //Aprendizaje inicial
        if ($request->input('Nivel') == 'Inicial') {
            $request->validate([
                'aprendizaje_inicial'=>'required',
            ]);

            $query = DB::table('aprendizajes')->where('id', $id_aprend)->update([
                'Descripcion_aprendizaje'=>$request->input('aprendizaje_inicial'),
            ]);

            return back()->withSuccess('Aprendizaje actualizado con éxito');
        }

        //Aprendizaje en desarrollo
        else if ($request->input('Nivel') == 'En desarrollo') {
            $request->validate([
                'aprendizaje_desarrollo'=>'required',
            ]);

            $query = DB::table('aprendizajes')->where('id', $id_aprend)->update([
                'Descripcion_aprendizaje'=>$request->input('aprendizaje_desarrollo'),
            ]);

            return back()->withSuccess('Aprendizaje actualizado con éxito');
        }

        //Aprendizaje logrado
        else if ($request->input('Nivel') == 'Logrado') {
            $request->validate([
                'aprendizaje_logrado'=>'required',
            ]);

            $query = DB::table('aprendizajes')->where('id', $id_aprend)->update([
                'Descripcion_aprendizaje'=>$request->input('aprendizaje_logrado'),
            ]);

            return back()->withSuccess('Aprendizaje actualizado con éxito');
        }

        //Aprendizaje especializacion
        else if ($request->input('Nivel') == 'Especializacion') {
            $request->validate([
                'aprendizaje_especializacion'=>'required',
            ]);

            $query = DB::table('aprendizajes')->where('id', $id_aprend)->update([
                'Descripcion_aprendizaje'=>$request->input('aprendizaje_especializacion'),
            ]);

            return back()->withSuccess('Aprendizaje actualizado con éxito');
        }

        return back()->withAlert('No se pudo modificar el aprendizaje');
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
