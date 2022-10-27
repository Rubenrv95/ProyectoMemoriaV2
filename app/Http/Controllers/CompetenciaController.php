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
        $competencia = DB::table('competencias')->where('refCarrera', $id_carrera)->get();
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
            'Descripcion'=>$request->input('desc_competencia'),
            'Orden'=>$request->input('orden_competencia'),
            'refCarrera'=>$id_carrera,
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

        $competencia = DB::table('competencias')->where('refCarrera', $id_carrera)->get();
        $competencia = json_decode($competencia, true);

        $tempo_competencia = DB::table('tempo_competencias')->leftJoin('competencias', 'competencias.id', '=', 'tempo_competencias.competencia')->where('competencias.refCarrera', $id_carrera)->get();;
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
            'Descripcion'=>$request->input('desc_competencia'),
            'Orden'=>$request->input('orden_competencia'),
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
        $query = DB::table('competencias')->where('id', $id_comp)->delete();

        $query2= 'DELETE tempo_competencias, dimensions, aprendizajes, tempo_aprendizajes, sabers, propuesta_modulos, propuesta_tiene_saber, modulos, modulo_tiene_prerrequisito FROM tempo_competencias
            INNER JOIN dimensions ON tempo_competencias.competencia = dimensions.refCompetencia
            INNER JOIN aprendizajes ON aprendizajes.refDimension = dimensions.id
            INNER JOIN tempo_aprendizajes ON aprendizajes.id = tempo_aprendizajes.aprendizaje
            INNER JOIN sabers ON sabers.refAprendizaje = aprendizajes.id
            INNER JOIN propuesta_tiene_saber ON sabers.id = propuesta_tiene_saber.saber
            INNER JOIN propuesta_modulos  ON  propuesta_tiene_saber.propuesta_modulo = propuesta_modulos.id
            INNER JOIN modulos  ON  propuesta_modulos.id = modulos.refPropuesta
            INNER JOIN modulo_tiene_prerrequisito  ON  modulos.id = modulo_tiene_prerrequisito.modulo
            WHERE dimensions.refCompetencia = ?';



        $query = DB::table('tempo_competencias')->where('competencia', $id_comp)->delete();

        $status = \DB::delete($query2, array($id_comp));
        
        return back()->withSuccess('Competencia eliminada con éxito');
    }
}
