<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Carrera;
use App\Models\Modulo;
use App\Models\Competencia;
use App\Models\Aprendizaje;
use App\Models\Saber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;


class PlanController extends Controller
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
    public function index()
    {
        $query = DB::table('plans')->orderBy('Nombre')->join('carreras', 'plans.Carrera_asociada', '=', 'carreras.id')->select('plans.Nombre', 'plans.id', 'carreras.nombre as Ncarrera', 'carreras.id as idCarrera')->get();
        $query = json_decode($query, true);
        return view ('planes.vistaplanes')->with('data', $query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $request->validate([
            'nombre_plan'=>'required'
        ]);


        $query = DB::table('plans')->insert([
            'Nombre'=>$request->input('nombre_plan'),
            'Carrera_asociada'=>$request->input('nombre_carrera'),
        ]);



        return back()->withSuccess('Plan de estudio creado con éxito');
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
     * copy and create resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function copy(Request $request, $carrera, $plan)
    {
        $plan = Plan::find($plan);

        //$plan= json_encode($plan, true);

        $newPlan = $plan->replicate()->fill(
            [
                'Nombre' => $request->input('nombre_plan_nuevo'),
            ]
        );
        //$newTask->project_id = 16; // the new project_id
        $newPlan->save();

        


        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show($id, $plan)
    {

        $query = DB::table('plans')->where('id', $plan)->get();
        $carrera = DB::table('carreras')->where('id', $id)->get(); 
        $modulo =  DB::table('modulos')->where('refPlan', $plan)->get(); 
        $query = json_decode($query, true);
        $carrera = json_decode($carrera, true);

        $competencia = DB::table('competencias')->where('refPlan', $plan)->get();
        $aprendizaje = DB::table('aprendizajes')->leftJoin('competencias', 'aprendizajes.refCompetencia', '=', 'competencias.id')->where('competencias.refPlan', '=', $plan)->select('aprendizajes.*', 'competencias.Descripcion')->get();
        $saber = DB::table('sabers')->leftJoin('aprendizajes', 'sabers.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('competencias', 'aprendizajes.refCompetencia', '=', 'competencias.id')->where('competencias.refPlan', '=', $plan)->select('sabers.*', 'aprendizajes.Descripcion_aprendizaje', 'competencias.refPlan')->get();
        $competencia = json_decode($competencia, true);
        $aprendizaje = json_decode($aprendizaje, true);
        $saber = json_decode($saber, true);

        return view('editar')->with('plan', $query)->with('carrera', $carrera)->with('saber', $saber);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update($id, $plan, Request $request)
    {

        $request->validate([
            'nombre_plan'=>'required'

        ]);


        $query = DB::table('plans')->where('id', $plan)->update([
            'Nombre'=>$request->input('nombre_plan'),
        ]);
        

        return back()->withSuccess('Plan de estudio actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $plan)
    {

        //se eliminan todas las competencias, aprendizajes y saberes asociados al plan de estudio
        $competencias = DB::table('competencias')->where('refPlan', $plan)->delete();
        $aprendizajes = DB::table('aprendizajes')->where('refPlan', $plan)->delete();
        $saberes = DB::table('sabers')->where('refPlan', $plan)->delete();

        $query = DB::table('plans')->where('id', $plan)->delete();

        return back()->withSuccess('Plan de estudio eliminado con éxito');
    }
}
