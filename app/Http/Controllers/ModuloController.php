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
use Validator;

class ModuloController extends Controller
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

        $saber = DB::table('saberes')->leftJoin('propuesta_tiene_saber', 'saberes.id', '=', 'propuesta_tiene_saber.saber')->leftJoin('aprendizajes', 'saberes.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->whereNull('propuesta_tiene_saber.saber')->select('saberes.*')->get();
        $coleccion= collect(DB::table('propuesta_modulos')->leftJoin('propuesta_tiene_saber', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')->leftJoin('saberes', 'propuesta_tiene_saber.saber', '=', 'saberes.id')->leftJoin('aprendizajes', 'saberes.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('propuesta_modulos.*', 'propuesta_tiene_saber.propuesta_modulo as prop', 'saberes.Descripcion_saber', 'saberes.Tipo', 'aprendizajes.Descripcion_aprendizaje', 'aprendizajes.Nivel_aprend', 'dimensions.Descripcion_dimension', 'dimensions.Orden as OrdenDim', 'competencias.Orden as OrdenComp', 'competencias.Descripcion')->get());

        $modulo = $coleccion->unique('prop');
        $modulo->values()->all();
        
        $saber = json_decode($saber, true);
        $modulo = json_decode($modulo, true);

        return view('carreras.propuestamodulos')->with('carrera', $carrera)->with('modulo', $modulo)->with('saber', $saber);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_carrera, Request $request)
    {

        $rules = [];

        $random = $this->newRandomInt();

        $request->validate([
            'nombre_modulo'=>'required',
            'semestre'=>'required'
        ]);

        foreach($request->input('saber') as $key => $value) {

            $rules["saber.{$key}"] = 'required';

        }


        $query = DB::table('propuesta_modulos')->insert([
            'id'=>$random,
            'Nombre_modulo'=>$request->input('nombre_modulo'),
            'Semestre'=>$request->input('semestre'),
        ]);



        foreach($request->input('saber') as $key => $value) {

            $query = DB::table('propuesta_tiene_saber')->insert([
                'propuesta_modulo'=>$random,
                'saber'=>$value,
            ]);
    

        }


        return back()->withSuccess('Se ha creado el módulo con éxito');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_carga($id_carrera, Request $request)
    {

        $rules = [];

        $query = DB::table('modulos')->insert([
            'refPropuesta'=>$request->input('modulo'),
            'Tipo'=>$request->input('curso'),
            'Creditos'=>$request->input('creditos'),
            'Horas_semanales'=>$request->input('horas_semanales'),
            'Horas_totales'=>$request->input('horas_totales'),

        ]);

        foreach($request->input('requisito') as $key => $value) {

            $query = DB::table('modulo_tiene_prerrequisito')->insert([
                'propuesta_modulo'=>$random,
                'saber'=>$value,
            ]);
    

        }

        return back()->withSuccess('Se ha creado el módulo con éxito');
    }


    /** Creamos un int random como ID para el modulo */
    private function newRandomInt()
    {
        $number = random_int(1000000000, 9999999999); 
        $isUsed =  DB::table('propuesta_modulos')->where('id', $number)->first();
        if ($isUsed) {
            return $this->newRandomInt(); //volvemos a llamar a la función si el ID creado ya existe
        }
        return $number;
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
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */

     /**Función para retornar las competencias, aprendizajes y saberes asociados al módulo */
    public function show_datos($id_carrera, $id_modulo)
    {


        $saber = DB::table('competencias')->leftJoin('dimensions', 'competencias.id', '=', 'dimensions.refCompetencia')->leftJoin('aprendizajes', 'dimensions.id', '=', 'aprendizajes.refDimension')->leftJoin('saberes', 'aprendizajes.id', '=', 'saberes.refAprendizaje')->leftJoin('propuesta_tiene_saber', 'saberes.id', '=', 'propuesta_tiene_saber.saber')->where('propuesta_tiene_saber.propuesta_modulo', '=', $id_modulo)->select('competencias.Descripcion', 'saberes.Descripcion_saber', 'saberes.Tipo', 'aprendizajes.Descripcion_aprendizaje', 'aprendizajes.Nivel_aprend')->get();
        $saber = json_decode($saber, true);

        
        return response()->json($saber);
    }


    public function show($id_carrera)
    {

        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);



        $coleccion= collect(DB::table('propuesta_modulos')->leftJoin('propuesta_tiene_saber', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')->leftJoin('saberes', 'propuesta_tiene_saber.saber', '=', 'saberes.id')->leftJoin('aprendizajes', 'saberes.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('propuesta_modulos.*', 'propuesta_tiene_saber.propuesta_modulo as prop', 'saberes.Descripcion_saber', 'saberes.Tipo', 'aprendizajes.Descripcion_aprendizaje', 'aprendizajes.Nivel_aprend', 'dimensions.Descripcion_dimension', 'dimensions.Orden as OrdenDim', 'competencias.Orden as OrdenComp', 'competencias.Descripcion')->get());

        $modulo = $coleccion->unique('prop');
        $modulo->values()->all();        
        $modulo = json_decode($modulo, true);


        return view('carreras.cargaacademica')->with('carrera', $carrera)->with('modulo', $modulo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modulo $modulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_carrera, $id_modulo)
    {
        $query = DB::table('propuesta_modulos')->where('id', $id_modulo)->update([
            'Nombre_modulo'=>$request->input('nombre_modulo'),
            'Semestre'=>$request->input('semestre'),
        ]);

        return back()->withSuccess('Módulo actualizado con éxito');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function update_carga(Request $request, $id_carrera, $id_modulo)
    {
        $query = DB::table('propuesta_modulos')->where('id', $id_modulo)->update([
            'Nombre_modulo'=>$request->input('nombre_modulo'),
            'Semestre'=>$request->input('semestre'),
        ]);

        return back()->withSuccess('Módulo actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_carrera, $id_modulo)
    {
        $query = DB::table('propuesta_modulos')->where('id', $id_modulo)->delete();
        $query2 = DB::table('propuesta_tiene_saber')->where('propuesta_modulo', $id_modulo)->delete();

        return back()->withSuccess('Módulo eliminado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function destroy_carga($id_carrera, $id_modulo)
    {
        $query = DB::table('propuesta_modulos')->where('id', $id_modulo)->delete();
        $query2 = DB::table('propuesta_tiene_saber')->where('propuesta_modulo', $id_modulo)->delete();

        return back()->withSuccess('Módulo eliminado con éxito');
    }
}
