<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use Illuminate\Http\Request;
use App\Models\Carrera;
use Illuminate\Support\Facades\DB;
use Datatables;

class CompetenciaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Se muestran las competencias
     *@param id_carrera, id de la carrera
     */
    public function index($id_carrera)
    {

        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);
        $competencia = DB::table('competencias')->where('refcarrera', $id_carrera)->get();
        $competencia = json_decode($competencia, true);
        return view('carreras.competencias')->with('carrera', $carrera)->with('competencia', $competencia);
    }

    /**
     * Se crea una competencia
     *@param id_carrera, id de la carrera
     */
    public function create($id_carrera, Request $request)
    {


        $random = $this->newRandomInt();


        $request->validate([
            'desc_competencia'=>'required',
            'orden_competencia'=>'required',
        ]);


        $query = DB::table('competencias')->insert([
            'id' => $random,
            'descripcion'=>$request->input('desc_competencia'),
            'orden'=>$request->input('orden_competencia'),
            'refcarrera'=>$id_carrera,
        ]);


        $query2 = DB::table('tempo_competencias')->insert([
            'competencia' => $random,
        ]);


        return back()->withSuccess('Competencia creada con éxito');
    }

    /** Creamos un int random como ID para la competencia*/
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
     * Mostrar las temporalizaciones de las competencias 
     *@param id_carrera, id de la carrera
     * 
     */
    public function show($id_carrera)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);

        $competencia = DB::table('competencias')->where('refcarrera', $id_carrera)->get();
        $competencia = json_decode($competencia, true);

        $tempo_competencia = DB::table('tempo_competencias')->leftJoin('competencias', 'competencias.id', '=', 'tempo_competencias.competencia')->where('competencias.refcarrera', $id_carrera)->get();;
        $tempo_competencia = json_decode($tempo_competencia, true);
        
        return view('carreras.tempo_competencias')->with('carrera', $carrera)->with('competencia', $competencia)->with('tempo', $tempo_competencia);

    }
    

    /**
     * Vista para editar la temporalización de una competencia
     *@param id_carrera, id de la carrera
     *@param id_comp, id de la competencia
     */
    public function edit($id_carrera, $id_comp)
    {
        $carrera = DB::table('carreras')->where('id', $id_carrera)->get(); 
        $carrera = json_decode($carrera, true);

        $tempo_competencia = DB::table('tempo_competencias')->leftJoin('competencias', 'competencias.id', '=', 'tempo_competencias.competencia')->where('competencias.id', $id_comp)->get();
        $tempo_competencia = json_decode($tempo_competencia, true);

        return view('carreras.editar_tempo_comp')->with('carrera', $carrera)->with('tempo', $tempo_competencia);
    }

    /**
     * Actualizar tempo de competencia seleccionada
     *@param id_carrera, id de la carrera
     *@param id_comp, id de la competencia
     */
    public function update_tempo($id_carrera, $id_comp, Request $request)
    {

        $query = DB::table('tempo_competencias')->where('competencia', $id_comp)->update([
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


        return back()->withSuccess('La temporalización de la competencia se ha actualizado con éxito');
    }

    /**
     * Actualizar competencia
     *@param id_carrera, id de la carrera
     * @param id_comp, id de la competencia
     */
    public function update($id_carrera, Request $request, $id_comp)
    {
        $request->validate([
            'desc_competencia'=>'required',
            'orden_competencia'=>'required',
        ]);


        $query = DB::table('competencias')->where('id', $id_comp)->update([
            'descripcion'=>$request->input('desc_competencia'),
            'orden'=>$request->input('orden_competencia'),
        ]);

        $competencia = Competencia::find($id_comp);
        $competencia -> touch();

        return back()->withSuccess('Competencia actualizada con éxito');
    }

    /**
     * eliminar competencia y todo elemento asociado
     *@param id, id de la carrera
     * @param id_comp, id de la competencia
     */
    public function destroy($id, $id_comp)
    {

        $query= 'DELETE tempo_competencias, dimensions, aprendizajes, tempo_aprendizajes, sabers, propuesta_modulos, propuesta_tiene_saber FROM tempo_competencias
            INNER JOIN dimensions ON tempo_competencias.competencia = dimensions.refcompetencia
            INNER JOIN aprendizajes ON aprendizajes.refdimension = dimensions.id
            INNER JOIN tempo_aprendizajes ON aprendizajes.id = tempo_aprendizajes.aprendizaje
            INNER JOIN sabers ON sabers.refaprendizaje = aprendizajes.id
            INNER JOIN propuesta_tiene_saber ON sabers.id = propuesta_tiene_saber.saber
            INNER JOIN propuesta_modulos ON propuesta_tiene_saber.propuesta_modulo = propuesta_modulos.id
            WHERE dimensions.refcompetencia = ?';


        $status = \DB::delete($query, array($id_comp));

        $query2 = DB::table('competencias')->where('id', $id_comp)->delete();



        
        return back()->withSuccess('Competencia eliminada con éxito');
    }
}
