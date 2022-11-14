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
        ->where('refcarrera', $id_carrera)
        ->orderByRaw('orden * 1 asc')
        ->get();
        $dimension =  DB::table('dimensions')
        ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
        ->where('competencias.refcarrera', '=', $id_carrera)
        ->select('dimensions.*', 'competencias.descripcion', 'competencias.orden as OrdenComp', 'competencias.id as idComp')
        ->get();
        $aprendizaje = DB::table('aprendizajes')
        ->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
        ->where('competencias.refcarrera', '=', $id_carrera)
        ->select('aprendizajes.*', 'competencias.descripcion', 'competencias.orden as OrdenComp', 'competencias.id as idComp', 'dimensions.descripcion_dimension', 'dimensions.orden', 'dimensions.id as idDim')
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
            'descripcion_aprendizaje'=>$request->input('aprendizaje_desc'),
            'refdimension'=>$request->input('dimension'),
            'nivel_aprend'=>$request->input('nivel'),
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

        $dim =  DB::table('dimensions')->where('dimensions.refcompetencia', '=', $id_competencia)->orderByRaw('orden * 1 asc')->get();

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
        ->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'competencias.id', '=', 'dimensions.refcompetencia')
        ->select('aprendizajes.*', 'competencias.descripcion', 'competencias.Orden as OrdenComp', 'competencias.id as idComp', 'dimensions.descripcion_dimension', 'dimensions.Orden as OrdenDim', 'dimensions.id as idDim')
        ->where('competencias.refcarrera', '=', $id_carrera)
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

        $tempo_aprendizaje = DB::table('tempo_aprendizajes')->leftJoin('aprendizajes', 'aprendizajes.id', '=', 'tempo_aprendizajes.aprendizaje')->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')->where('competencias.refcarrera', '=', $id_carrera)->select('aprendizajes.*', 'tempo_aprendizajes.*', 'competencias.descripcion', 'competencias.orden as OrdenComp', 'dimensions.descripcion_dimension', 'dimensions.orden')->get();
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

        $tempo_aprendizaje = DB::table('tempo_aprendizajes')->leftJoin('aprendizajes', 'aprendizajes.id', '=', 'tempo_aprendizajes.aprendizaje')->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')->where('aprendizajes.id', '=', $id_aprend)->select('aprendizajes.*', 'tempo_aprendizajes.*', 'competencias.descripcion', 'competencias.orden as OrdenComp', 'dimensions.descripcion_dimension', 'dimensions.orden')->get();
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
            'nivel_1' =>$request->input('nivel_1'),
            'nivel_2' =>$request->input('nivel_2'),
            'nivel_3' =>$request->input('nivel_3'),
            'nivel_4' =>$request->input('nivel_4'),
            'nivel_5' =>$request->input('nivel_5'),
            'nivel_6' =>$request->input('nivel_6'),
            'nivel_7' =>$request->input('nivel_7'),
            'nivel_8' =>$request->input('nivel_8'),
            'nivel_9' =>$request->input('nivel_9'),
            'nivel_10' =>$request->input('nivel_10'),
            'nivel_11' =>$request->input('nivel_11'),
            'nivel_12' =>$request->input('nivel_12'),
            'nivel_13' =>$request->input('nivel_13'),
            'nivel_14' =>$request->input('nivel_14'),
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
                'descripcion_aprendizaje'=>$request->input('aprendizaje_inicial'),
                'nivel_aprend'=>$request->input('nivel_inicial'),
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
                'descripcion_aprendizaje'=>$request->input('aprendizaje_desarrollo'),
                'nivel_aprend'=>$request->input('nivel_desarrollo'),
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
                'descripcion_aprendizaje'=>$request->input('aprendizaje_logrado'),
                'nivel_aprend'=>$request->input('nivel_logrado'),
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
                'descripcion_aprendizaje'=>$request->input('aprendizaje_especializacion'),
                'nivel_aprend'=>$request->input('nivel_especializacion'),
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
        INNER JOIN sabers ON sabers.refaprendizaje = tempo_aprendizajes.aprendizaje
        INNER JOIN propuesta_tiene_saber ON sabers.id = propuesta_tiene_saber.saber
        INNER JOIN propuesta_modulos  ON  propuesta_tiene_saber.propuesta_modulo = propuesta_modulos.id
        INNER JOIN modulos  ON  propuesta_modulos.id = modulos.refpropuesta
        INNER JOIN modulo_tiene_prerrequisito  ON  modulos.id = modulo_tiene_prerrequisito.modulo
        WHERE sabers.refaprendizaje = ?';

        $status = \DB::delete($query2, array($id_aprend));

        
        return back()->withSuccess('Aprendizaje eliminado con éxito');
    }
}
