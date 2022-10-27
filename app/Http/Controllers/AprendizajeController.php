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
     * Se muestran los aprendizajes en la vista de gestión
     * @param id_carrera, id de la carrera
     */
    public function index($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);
        
        $competencia = DB::table('competencias')
        ->where('refCarrera', $id_carrera)
        ->get();
        $dimension =  DB::table('dimensions')
        ->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')
        ->where('competencias.refCarrera', '=', $id_carrera)
        ->select('dimensions.*', 'competencias.Descripcion', 'competencias.Orden as OrdenComp', 'competencias.id as idComp')
        ->get();
        $aprendizaje = DB::table('aprendizajes')
        ->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')
        ->where('competencias.refCarrera', '=', $id_carrera)
        ->select('aprendizajes.*', 'competencias.Descripcion', 'competencias.Orden as OrdenComp', 'competencias.id as idComp', 'dimensions.Descripcion_dimension', 'dimensions.Orden', 'dimensions.id as idDim')
        ->get();


        $competencia = json_decode($competencia, true);
        $aprendizaje = json_decode($aprendizaje, true);
        $dimension = json_decode($dimension, true);
        
        return view('carreras.aprendizajes')->with('carrera', $carrera)->with('competencia', $competencia)->with('aprendizaje', $aprendizaje)->with('dimension', $dimension);
    }

    /**
     * Se crea un aprendizaje
     * @param id_carrera, id de la carrera
     */
    public function create($id_carrera, Request $request)
    {
        $request->validate([
            'aprendizaje_desc'=>'required',
        ]);

        $random = $this->newRandomInt();

        $query = DB::table('aprendizajes')->insert([
            'id' => $random,
            'Descripcion_aprendizaje'=>$request->input('aprendizaje_desc'),
            'refDimension'=>$request->input('dimension'),
            'Nivel_aprend'=>$request->input('nivel'),
        ]);

        $query2 = DB::table('tempo_aprendizajes')->insert([
            'aprendizaje' => $random,
        ]);


        return back()->withSuccess('Aprendizaje creado con éxito');
    }

      /** Creamos un int random como ID para el aprendizaje*/
      private function newRandomInt()
      {
          $number = random_int(1, 9999999999); 
  
          
          $isUsed =  DB::table('propuesta_modulos')->where('id', $number)->first();
          if ($isUsed) {
              return $this->newRandomInt($tabla); //volvemos a llamar a la función si el ID creado ya existe
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
     * Se muestran las dimensiones de una competencia seleccionada en el modal de creación
     * @param id_carrera, id de la carrera
     *@param id_comp, id de la competencia
     */
    public function show($id_carrera, $id_competencia)
    {

        $dim =  DB::table('dimensions')->where('dimensions.refCompetencia', '=', $id_competencia)->get();

        return response()->json($dim);
    }


    /**
     * Se retornan los aprendizajes ya creados en una tabla
     * @param id_carrera, id de la carrera
     */
    public function show_aprendizajes($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);

        $aprendizaje =  DB::table('aprendizajes')
        ->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'competencias.id', '=', 'dimensions.refCompetencia')
        ->select('aprendizajes.*', 'competencias.Descripcion', 'competencias.Orden as OrdenComp', 'competencias.id as idComp', 'dimensions.Descripcion_dimension', 'dimensions.Orden as OrdenDim', 'dimensions.id as idDim')
        ->where('competencias.refCarrera', '=', $id_carrera)
        ->get();
        $aprendizaje = json_decode($aprendizaje, true);
        
        return view('carreras.ver_aprendizajes')->with('carrera', $carrera)->with('aprendizaje', $aprendizaje);
    }
    
    

       /**
     * Vista de temporalización de aprendizajes
     * @param id_carrera, id de la carrera
     */
    public function show_Tempo($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);

        $tempo_aprendizaje = DB::table('tempo_aprendizajes')->leftJoin('aprendizajes', 'aprendizajes.id', '=', 'tempo_aprendizajes.aprendizaje')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $id_carrera)->select('aprendizajes.*', 'tempo_aprendizajes.*', 'competencias.Descripcion', 'competencias.Orden as OrdenComp', 'dimensions.Descripcion_dimension', 'dimensions.Orden')->get();
        $tempo_aprendizaje = json_decode($tempo_aprendizaje, true);

        return view('carreras.tempo_aprendizajes')->with('carrera', $carrera)->with('tempo', $tempo_aprendizaje);

    }

    

   /**
     * Vista para editar la temporalización de un aprendizaje
     * @param id_carrera, id de la carrera
     *@param id_aprend, id del aprendizaje
     */
    public function edit($id_carrera, $id_aprend)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);

        $tempo_aprendizaje = DB::table('tempo_aprendizajes')->leftJoin('aprendizajes', 'aprendizajes.id', '=', 'tempo_aprendizajes.aprendizaje')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('aprendizajes.id', '=', $id_aprend)->select('aprendizajes.*', 'tempo_aprendizajes.*', 'competencias.Descripcion', 'competencias.Orden as OrdenComp', 'dimensions.Descripcion_dimension', 'dimensions.Orden')->get();
        $tempo_aprendizaje = json_decode($tempo_aprendizaje, true);

        return view('carreras.editar_tempo_aprend')->with('carrera', $carrera)->with('tempo', $tempo_aprendizaje);
    }

    /**
     * Actualizar tempo de aprendizaje seleccionada
     * @param id_carrera, id de la carrera
     *@param id_aprend, id del aprendizaje
     */
    public function update_tempo($id_carrera,  $id_aprend, Request $request)
    {

        $query = DB::table('tempo_aprendizajes')->where('aprendizaje',  $id_aprend)->update([
            '1' =>$request->input('nivel_1'),
            '2' =>$request->input('nivel_2'),
            '3' =>$request->input('nivel_3'),
            '4' =>$request->input('nivel_4'),
            '5' =>$request->input('nivel_5'),
            '6' =>$request->input('nivel_6'),
            '7' =>$request->input('nivel_7'),
            '8' =>$request->input('nivel_8'),
            '9' =>$request->input('nivel_9'),
            '10' =>$request->input('nivel_10'),
            '11' =>$request->input('nivel_11'),
            '12' =>$request->input('nivel_12'),
            '13' =>$request->input('nivel_13'),
            '14' =>$request->input('nivel_14'),
        ]);


        return back()->withSuccess('La temporalización del aprendizaje se ha actualizado con éxito');
    }

    /**
     * Actualizar aprendizaje
     * @param id_carrera, id de la carrera
     *@param id_aprend, id del aprendizaje
     */
    public function update($id_carrera, Request $request, $id_aprend)
    {

        $aprendizaje = Aprendizaje::find($id_aprend);

        //Aprendizaje inicial
        if ($request->input('Nivel') == 'Inicial') {
            $request->validate([
                'aprendizaje_inicial'=>'required',
            ]);

            $query = DB::table('aprendizajes')->where('id', $id_aprend)->update([
                'Descripcion_aprendizaje'=>$request->input('aprendizaje_inicial'),
                'Nivel_aprend'=>$request->input('nivel_inicial'),
            ]);
            $aprendizaje -> touch();


            return back()->withSuccess('Aprendizaje actualizado con éxito');
        }

        //Aprendizaje en desarrollo
        else if ($request->input('Nivel') == 'En desarrollo') {
            $request->validate([
                'aprendizaje_desarrollo'=>'required',
            ]);

            $query = DB::table('aprendizajes')->where('id', $id_aprend)->update([
                'Descripcion_aprendizaje'=>$request->input('aprendizaje_desarrollo'),
                'Nivel_aprend'=>$request->input('nivel_desarrollo'),
            ]);

            $aprendizaje -> touch();

            return back()->withSuccess('Aprendizaje actualizado con éxito');
        }

        //Aprendizaje logrado
        else if ($request->input('Nivel') == 'Logrado') {
            $request->validate([
                'aprendizaje_logrado'=>'required',
            ]);

            $query = DB::table('aprendizajes')->where('id', $id_aprend)->update([
                'Descripcion_aprendizaje'=>$request->input('aprendizaje_logrado'),
                'Nivel_aprend'=>$request->input('nivel_logrado'),
            ]);

            $aprendizaje -> touch();
            return back()->withSuccess('Aprendizaje actualizado con éxito');
        }

        //Aprendizaje especializacion
        else if ($request->input('Nivel') == 'Especialización') {
            $request->validate([
                'aprendizaje_especializacion'=>'required',
            ]);

            $query = DB::table('aprendizajes')->where('id', $id_aprend)->update([
                'Descripcion_aprendizaje'=>$request->input('aprendizaje_especializacion'),
                'Nivel_aprend'=>$request->input('nivel_especializacion'),
            ]);

            $aprendizaje -> touch();
            return back()->withSuccess('Aprendizaje actualizado con éxito');
        }

        return back()->withAlert('No se pudo modificar el aprendizaje');
    }

    /**
     * Eliminar aprendizaje y todo elemento asociado
     * @param id_carrera, id de la carrera
     *@param id_aprend, id del aprendizaje
     */
    public function destroy($id_carrera, $id_aprend)
    {
        $query = DB::table('aprendizajes')->where('id', $id_aprend)->delete();

        $query2= 'DELETE tempo_aprendizajes, sabers, propuesta_modulos, propuesta_tiene_saber, modulos, modulo_tiene_prerrequisito FROM tempo_aprendizajes
        INNER JOIN sabers ON sabers.refAprendizaje = tempo_aprendizajes.aprendizaje
        INNER JOIN propuesta_tiene_saber ON sabers.id = propuesta_tiene_saber.saber
        INNER JOIN propuesta_modulos  ON  propuesta_tiene_saber.propuesta_modulo = propuesta_modulos.id
        INNER JOIN modulos  ON  propuesta_modulos.id = modulos.refPropuesta
        INNER JOIN modulo_tiene_prerrequisito  ON  modulos.id = modulo_tiene_prerrequisito.modulo
        WHERE sabers.refAprendizaje = ?';

        $status = \DB::delete($query2, array($id_aprend));

        
        return back()->withSuccess('Aprendizaje eliminado con éxito');
    }
}
