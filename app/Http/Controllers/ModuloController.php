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
     * Vista de propuesta de módulos
     */
    public function index($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);

        $saber = DB::table('sabers')
        ->leftJoin('propuesta_tiene_saber', 'sabers.id', '=', 'propuesta_tiene_saber.saber')
        ->leftJoin('aprendizajes', 'sabers.refaprendizaje', '=', 'aprendizajes.id')
        ->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
        ->orderBy('sabers.nivel')
        ->where('competencias.refcarrera', '=', $id_carrera)
        ->whereNull('propuesta_tiene_saber.saber')
        ->select('sabers.*')
        ->get();

        $coleccion= collect(DB::table('propuesta_modulos')
        ->leftJoin('propuesta_tiene_saber', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')
        ->leftJoin('sabers', 'propuesta_tiene_saber.saber', '=', 'sabers.id')
        ->leftJoin('aprendizajes', 'sabers.refaprendizaje', '=', 'aprendizajes.id')
        ->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
        ->where('competencias.refcarrera', '=', $id_carrera)
        ->select('propuesta_modulos.*', 'propuesta_tiene_saber.propuesta_modulo as prop', 'sabers.descripcion_saber', 'sabers.tipo', 'aprendizajes.descripcion_aprendizaje', 'aprendizajes.nivel_aprend', 'dimensions.descripcion_dimension', 'dimensions.orden as OrdenDim', 'competencias.orden as OrdenComp', 'competencias.descripcion')
        ->get());

        $propuestas = $coleccion->unique('prop');
        $propuestas->values()->all();

        $propuestas = json_decode($propuestas, true);
        $saber = json_decode($saber, true);

        return view('carreras.propuestamodulos')->with('carrera', $carrera)->with('propuestas', $propuestas)->with('saber', $saber);
    }

    /**
     * Se crea una propuesta de módulo
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
            'nombre_modulo'=>$request->input('nombre_modulo'),
            'semestre'=>$request->input('semestre'),
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
     * Se crea un módulo en la tabla de carga académica
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
            'refpropuesta'=>$request->input('modulo'),
            'tipo'=>$request->input('curso'),
            'creditos'=>$request->input('creditos'),
            'horas_semanales'=>$request->input('horas_semanales'),
            'horas_totales'=>$request->input('horas_totales'),
            'clases'=>$request->input('clases'),
            'seminario'=>$request->input('seminario'),
            'actividades_practicas'=>$request->input('practicas'),
            'talleres'=>$request->input('talleres'),
            'laboratorios'=>$request->input('labs'),
            'actividades_clinicas'=>$request->input('clinicas'),
            'actividades_terreno'=>$request->input('terreno'),
            'ayudantias'=>$request->input('ayudantias'),
            'tareas'=>$request->input('tareas'),
            'estudios'=>$request->input('estudio'),

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


     /**Función para retornar las competencias, aprendizajes y saberes asociados al módulo */
    public function show_datos($id_carrera, $id_modulo)
    {


        $saber = DB::table('sabers')
        ->leftJoin('propuesta_tiene_saber', 'sabers.id', '=', 'propuesta_tiene_saber.saber')
        ->leftJoin('propuesta_modulos', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')
        ->where('propuesta_tiene_saber.propuesta_modulo', '=', $id_modulo)
        ->select('sabers.descripcion_saber', 'sabers.tipo', 'propuesta_modulos.nombre_modulo')
        ->get();

        $coleccion= collect(
            DB::table('competencias')
            ->leftJoin('dimensions', 'competencias.id', '=', 'dimensions.refcompetencia')
            ->leftJoin('aprendizajes', 'dimensions.id', '=', 'aprendizajes.refdimension')
            ->leftJoin('sabers', 'aprendizajes.id', '=', 'sabers.refaprendizaje')
            ->leftJoin('propuesta_tiene_saber', 'sabers.id', '=', 'propuesta_tiene_saber.saber')
            ->leftJoin('propuesta_modulos', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')
            ->where('propuesta_tiene_saber.propuesta_modulo', '=', $id_modulo)
            ->select('competencias.descripcion','competencias.orden', 'competencias.id as idComp')
            ->get()       
        );

        $competencias = $coleccion->unique('idComp');
        $competencias->values()->all();

        $coleccion2= collect(
            DB::table('aprendizajes')
            ->leftJoin('sabers', 'aprendizajes.id', '=', 'sabers.refaprendizaje')
            ->leftJoin('propuesta_tiene_saber', 'sabers.id', '=', 'propuesta_tiene_saber.saber')
            ->leftJoin('propuesta_modulos', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')
            ->where('propuesta_tiene_saber.propuesta_modulo', '=', $id_modulo)
            ->select('aprendizajes.descripcion_aprendizaje', 'aprendizajes.nivel_aprend', 'aprendizajes.id as idAprend')
            ->get()       
        );

        $aprendizajes = $coleccion2->unique('idAprend');
        $aprendizajes->values()->all();

        $saber = json_decode($saber, true);
        
        return response()->json([$saber, $aprendizajes, $competencias]);
    }


     /**Función para retornar las competencias, aprendizajes y sabers asociados al módulo */
     public function show_requisitos($id_carrera, $id_modulo)
     {
 
 

        //prerrequisitos del módulo seleccionado
         $req = DB::table('modulos')
         ->leftJoin('modulo_tiene_prerrequisito', 'modulo_tiene_prerrequisito.prerrequisito', '=', 'modulos.id')
         ->leftJoin('propuesta_modulos', 'propuesta_modulos.id', '=', 'modulos.refpropuesta')
         ->where('modulo_tiene_prerrequisito.modulo', '=', $id_modulo)
         ->select('modulos.*', 'propuesta_modulos.nombre_modulo')
         ->get();

         //nombre del módulo seleccionado
         $name = DB::table('modulos')
         ->leftJoin('propuesta_modulos', 'propuesta_modulos.id', '=', 'modulos.refpropuesta')
         ->where('modulos.id', '=', $id_modulo)
         ->select('propuesta_modulos.nombre_modulo')
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
            ->leftJoin('aprendizajes', 'sabers.refaprendizaje', '=', 'aprendizajes.id')
            ->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')
            ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
            ->where('competencias.refcarrera', '=', $id_carrera)
            ->select('modulos.*', 'propuesta_modulos.nombre_modulo', 'propuesta_modulos.semestre', 'propuesta_modulos.id as idprop')
            ->get()
        );

        $coleccion2= collect(
            DB::table('propuesta_modulos')
            ->leftJoin('modulos', 'propuesta_modulos.id', '=', 'modulos.refpropuesta')
            ->leftJoin('propuesta_tiene_saber', 'propuesta_modulos.id', '=', 'propuesta_tiene_saber.propuesta_modulo')
            ->leftJoin('sabers', 'propuesta_tiene_saber.saber', '=', 'sabers.id')
            ->leftJoin('aprendizajes', 'sabers.refaprendizaje', '=', 'aprendizajes.id')
            ->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')
            ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
            ->where('competencias.refcarrera', '=', $id_carrera)
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
     * Se actualiza la propuesta de módulo
     */
    public function update(Request $request, $id_carrera, $id_modulo)
    {
        $query = DB::table('propuesta_modulos')->where('id', $id_modulo)->update([
            'nombre_modulo'=>$request->input('nombre_modulo'),
            'semestre'=>$request->input('semestre'),
        ]);


        return back()->withSuccess('Módulo actualizado con éxito');
    }

    /**
     * Se actualiza el módulo de la carga
     */
    public function update_carga(Request $request, $id_carrera, $id_modulo)
    {
        $query = DB::table('modulos')->where('id', $id_modulo)->update([
            'refpropuesta'=>$request->input('modulo'),
            'tipo'=>$request->input('curso'),
            'creditos'=>$request->input('creditos'),
            'horas_semanales'=>$request->input('horas_semanales'),
            'horas_totales'=>$request->input('horas_totales'),
            'clases'=>$request->input('clases'),
            'seminario'=>$request->input('seminario'),
            'actividades_practicas'=>$request->input('practicas'),
            'talleres'=>$request->input('talleres'),
            'laboratorios'=>$request->input('labs'),
            'actividades_clinicas'=>$request->input('clinicas'),
            'actividades_terreno'=>$request->input('terreno'),
            'ayudantias'=>$request->input('ayudantias'),
            'tareas'=>$request->input('tareas'),
            'estudios'=>$request->input('estudio'),

        ]);

        return back()->withSuccess('Módulo actualizado con éxito');
    }

    /**
     * Se elimina la propuesta de módulo
     */
    public function destroy($id_carrera, $id_modulo)
    {
        $query = DB::table('propuesta_modulos')->where('id', $id_modulo)->delete();
        $query2 = DB::table('propuesta_tiene_saber')->where('propuesta_modulo', $id_modulo)->delete();
        
        $query3= 'DELETE modulos, modulo_tiene_prerrequisito FROM modulos
        INNER JOIN modulo_tiene_prerrequisito  ON  modulos.id = modulo_tiene_prerrequisito.modulo
        WHERE modulos.refpropuesta = ?';

        $status = \DB::delete($query3, array($id_modulo));

        $query4= DB::table('modulos')->where('refpropuesta', $id_modulo)->delete();

        return back()->withSuccess('Módulo eliminado con éxito');
    }

    /**
     * Se elimina el módulo de la carga académica
     */
    public function destroy_carga($id_carrera, $id_modulo)
    {
        $query = DB::table('modulos')->where('id', $id_modulo)->delete();
        $query2 = DB::table('modulo_tiene_prerrequisito')->where('modulo', $id_modulo)->delete();

        return back()->withSuccess('Módulo eliminado con éxito');
    }
}
