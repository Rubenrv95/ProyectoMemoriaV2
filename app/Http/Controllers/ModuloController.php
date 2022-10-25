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

        $saber = DB::table('sabers')->leftJoin('propuesta_tiene_saber', 'sabers.id', '=', 'propuesta_tiene_saber.saber')->leftJoin('aprendizajes', 'sabers.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->whereNull('propuesta_tiene_saber.saber')->select('sabers.*')->get();
        $coleccion= collect(DB::table('propuesta_modulos')->leftJoin('propuesta_tiene_saber', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')->leftJoin('sabers', 'propuesta_tiene_saber.saber', '=', 'sabers.id')->leftJoin('aprendizajes', 'sabers.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('propuesta_modulos.*', 'propuesta_tiene_saber.propuesta_modulo as prop', 'sabers.Descripcion_saber', 'sabers.Tipo', 'aprendizajes.Descripcion_aprendizaje', 'aprendizajes.Nivel_aprend', 'dimensions.Descripcion_dimension', 'dimensions.Orden as OrdenDim', 'competencias.Orden as OrdenComp', 'competencias.Descripcion')->get());

        $propuestas = $coleccion->unique('prop');
        $propuestas->values()->all();

        $propuestas = json_decode($propuestas, true);
        $saber = json_decode($saber, true);

        return view('carreras.propuestamodulos')->with('carrera', $carrera)->with('propuestas', $propuestas)->with('saber', $saber);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_carrera, Request $request)
    {

        $rules = [];

        $tabla = 'propuesta';

        $random = $this->newRandomInt($tabla);

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

        $request->validate([
            'creditos'=>'required',
            'horas_semanales'=>'required',
            'horas_totales'=>'required'
        ]);

        $tabla = 'carga';

        $random = $this->newRandomInt($tabla);


        $query = DB::table('modulos')->insert([
            'id' => $random,
            'refPropuesta'=>$request->input('modulo'),
            'Tipo'=>$request->input('curso'),
            'Creditos'=>$request->input('creditos'),
            'Horas_semanales'=>$request->input('horas_semanales'),
            'Horas_totales'=>$request->input('horas_totales'),
            'Clases'=>$request->input('clases'),
            'Seminario'=>$request->input('seminario'),
            'Actividades_practicas'=>$request->input('practicas'),
            'Talleres'=>$request->input('talleres'),
            'Laboratorios'=>$request->input('labs'),
            'Actividades_clinicas'=>$request->input('clinicas'),
            'Actividades_terreno'=>$request->input('terreno'),
            'Ayudantias'=>$request->input('ayudantias'),
            'Tareas'=>$request->input('tareas'),
            'Estudios'=>$request->input('estudio'),

        ]);

        if ($request->input('requisito') != null) {
            foreach($request->input('requisito') as $key => $value) {

                $query = DB::table('modulo_tiene_prerrequisito')->insert([
                    'modulo'=>$random,
                    'prerrequisito'=>$value,
                ]);
        
    
            }
        }

        

        return back()->withSuccess('Se ha creado el módulo con éxito');
    }


    /** Creamos un int random como ID para la propuesta de modulo o el módulo en sí */
    private function newRandomInt($tabla)
    {
        $number = random_int(1, 9999999999); 

        if ($tabla == 'propuesta') {
            $isUsed =  DB::table('propuesta_modulos')->where('id', $number)->first();
            if ($isUsed) {
                return $this->newRandomInt($tabla); //volvemos a llamar a la función si el ID creado ya existe
            }
            return $number;
        }
        else {
            $isUsed =  DB::table('modulos')->where('id', $number)->first();
            if ($isUsed) {
                return $this->newRandomInt($tabla); //volvemos a llamar a la función si el ID creado ya existe
            }
            return $number;
        }
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


        $saber = DB::table('sabers')
        ->leftJoin('propuesta_tiene_saber', 'sabers.id', '=', 'propuesta_tiene_saber.saber')
        ->leftJoin('propuesta_modulos', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')
        ->where('propuesta_tiene_saber.propuesta_modulo', '=', $id_modulo)
        ->select('sabers.Descripcion_saber', 'sabers.Tipo', 'propuesta_modulos.Nombre_modulo')
        ->get();

        $coleccion= collect(
            DB::table('competencias')
            ->leftJoin('dimensions', 'competencias.id', '=', 'dimensions.refCompetencia')
            ->leftJoin('aprendizajes', 'dimensions.id', '=', 'aprendizajes.refDimension')
            ->leftJoin('sabers', 'aprendizajes.id', '=', 'sabers.refAprendizaje')
            ->leftJoin('propuesta_tiene_saber', 'sabers.id', '=', 'propuesta_tiene_saber.saber')
            ->leftJoin('propuesta_modulos', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')
            ->where('propuesta_tiene_saber.propuesta_modulo', '=', $id_modulo)
            ->select('competencias.Descripcion','competencias.Orden', 'competencias.id as idComp')
            ->get()       
        );

        $competencias = $coleccion->unique('idComp');
        $competencias->values()->all();

        $coleccion2= collect(
            DB::table('aprendizajes')
            ->leftJoin('sabers', 'aprendizajes.id', '=', 'sabers.refAprendizaje')
            ->leftJoin('propuesta_tiene_saber', 'sabers.id', '=', 'propuesta_tiene_saber.saber')
            ->leftJoin('propuesta_modulos', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')
            ->where('propuesta_tiene_saber.propuesta_modulo', '=', $id_modulo)
            ->select('aprendizajes.Descripcion_aprendizaje', 'aprendizajes.Nivel_aprend', 'aprendizajes.id as idAprend')
            ->get()       
        );

        $aprendizajes = $coleccion2->unique('idAprend');
        $aprendizajes->values()->all();

        $saber = json_decode($saber, true);
        
        return response()->json([$saber, $aprendizajes, $competencias]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
     /**Función para retornar las competencias, aprendizajes y sabers asociados al módulo */
     public function show_requisitos($id_carrera, $id_modulo)
     {
 
 

        //prerrequisitos del módulo seleccionado
         $req = DB::table('modulos')
         ->leftJoin('modulo_tiene_prerrequisito', 'modulo_tiene_prerrequisito.prerrequisito', '=', 'modulos.id')
         ->leftJoin('propuesta_modulos', 'propuesta_modulos.id', '=', 'modulos.refPropuesta')
         ->where('modulo_tiene_prerrequisito.modulo', '=', $id_modulo)
         ->select('modulos.*', 'propuesta_modulos.Nombre_modulo')
         ->get();

         //nombre del módulo seleccionado
         $name = DB::table('modulos')
         ->leftJoin('propuesta_modulos', 'propuesta_modulos.id', '=', 'modulos.refPropuesta')
         ->where('modulos.id', '=', $id_modulo)
         ->select('propuesta_modulos.Nombre_modulo')
         ->get();


         $req = json_decode($req, true);
         $name = json_decode($name, true);
         
         return response()->json([$req, $name]);
     }


     //Función index de la vista de carga académica
    public function show($id_carrera)
    {

        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);



        $coleccion= collect(
             DB::table('modulos')
            ->leftJoin('propuesta_modulos', 'modulos.refPropuesta', '=', 'propuesta_modulos.id')
            ->leftJoin('propuesta_tiene_saber', 'propuesta_tiene_saber.propuesta_modulo', '=', 'propuesta_modulos.id')
            ->leftJoin('sabers', 'propuesta_tiene_saber.saber', '=', 'sabers.id')
            ->leftJoin('aprendizajes', 'sabers.refAprendizaje', '=', 'aprendizajes.id')
            ->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')
            ->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')
            ->where('competencias.refCarrera', '=', $id_carrera)
            ->select('modulos.*', 'propuesta_modulos.Nombre_modulo', 'propuesta_modulos.Semestre', 'propuesta_modulos.id as idprop')
            ->get()
        );

        $coleccion2= collect(
            DB::table('propuesta_modulos')
            ->leftJoin('modulos', 'propuesta_modulos.id', '=', 'modulos.refPropuesta')
            ->leftJoin('propuesta_tiene_saber', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')
            ->leftJoin('sabers', 'propuesta_tiene_saber.saber', '=', 'sabers.id')
            ->leftJoin('aprendizajes', 'sabers.refAprendizaje', '=', 'aprendizajes.id')
            ->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')
            ->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')
            ->where('competencias.refCarrera', '=', $id_carrera)
            ->select('propuesta_modulos.*', 'propuesta_tiene_saber.propuesta_modulo as prop')->get()
        );

       

        $modulo = $coleccion->unique('id');
        $modulo->values()->all();


        $propuestas = $coleccion2->unique('prop');
        $propuestas->values()->all();


        $propuestas = json_decode($propuestas, true);
        $modulo = json_decode($modulo, true);



        return view('carreras.cargaacademica')->with('carrera', $carrera)->with('modulo', $modulo)->with('propuestas', $propuestas);
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
        $query = DB::table('modulos')->where('id', $id_modulo)->update([
            'refPropuesta'=>$request->input('modulo'),
            'Tipo'=>$request->input('curso'),
            'Creditos'=>$request->input('creditos'),
            'Horas_semanales'=>$request->input('horas_semanales'),
            'Horas_totales'=>$request->input('horas_totales'),
            'Clases'=>$request->input('clases'),
            'Seminario'=>$request->input('seminario'),
            'Actividades_practicas'=>$request->input('practicas'),
            'Talleres'=>$request->input('talleres'),
            'Laboratorios'=>$request->input('labs'),
            'Actividades_clinicas'=>$request->input('clinicas'),
            'Actividades_terreno'=>$request->input('terreno'),
            'Ayudantias'=>$request->input('ayudantias'),
            'Tareas'=>$request->input('tareas'),
            'Estudios'=>$request->input('estudio'),

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
        
        $query3= 'DELETE modulos, modulo_tiene_prerrequisito FROM modulos
        INNER JOIN modulo_tiene_prerrequisito  ON  modulos.id = modulo_tiene_prerrequisito.modulo
        WHERE modulos.refPropuesta = ?';

        $status = \DB::delete($query3, array($id_modulo));

        $query4= DB::table('modulos')->where('refPropuesta', $id_modulo)->delete();

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
        $query = DB::table('modulos')->where('id', $id_modulo)->delete();
        $query2 = DB::table('modulo_tiene_prerrequisito')->where('modulo', $id_modulo)->delete();

        return back()->withSuccess('Módulo eliminado con éxito');
    }
}
