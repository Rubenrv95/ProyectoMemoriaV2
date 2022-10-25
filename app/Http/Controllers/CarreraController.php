<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use App\Http\Controllers\PlanController;
use PDF;


class CarreraController extends Controller
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
    public function index(Request $request)
    {
        $data = Carrera::orderBy('nombre')->get(); 
        return view ('/carreras', ['carrera'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'nombre_carrera'=>'required'
        ]);


        $query = DB::table('carreras')->insert([
            'nombre'=>$request->input('nombre_carrera'),
            'facultad'=>$request->input('facultad'),
            'formacion'=>$request->input('formacion'),
            'tipo'=>$request->input('tipo'),
        ]);


        return back()->withSuccess('Carrera creada con éxito');
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

    public function copy(Request $request, $carrera)
    {
        
    }

    public function createPDF($carrera) {
        $competencia = DB::table('competencias')->where('refCarrera', $carrera)->get();
        $aprendizaje = DB::table('aprendizajes')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $carrera)->select('aprendizajes.*', 'competencias.Descripcion', 'competencias.Orden as OrdenComp', 'competencias.id as idComp', 'dimensions.Descripcion_dimension', 'dimensions.Orden', 'dimensions.id as idDim')->get();
        $saber = DB::table('sabers')->leftJoin('aprendizajes', 'sabers.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $carrera)->select('sabers.*', 'aprendizajes.Descripcion_aprendizaje', 'dimensions.Descripcion_dimension', 'dimensions.Orden as OrdenDim', 'competencias.Orden as OrdenComp', 'competencias.Descripcion')->get();

        $carrera_seleccionada = DB::table('carreras')->where('id', $carrera)->get();
        $competencia = json_decode($competencia, true);
        $aprendizaje = json_decode($aprendizaje, true);
        $saber = json_decode($saber, true);
        
        $carrera_seleccionada = json_decode($carrera_seleccionada, true);
        $pdf = PDF::loadView('descargas.reporte', compact('carrera_seleccionada', 'competencia', 'aprendizaje', 'saber'));
        return $pdf->download('reporte.pdf');
      }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $carrera = DB::table('carreras')->where('id', $id)->get(); //carrera
        $result = DB::table('plans')->where('Carrera_asociada', $id)->get(); //los planes de la carrera
        $data = json_decode($result, true);
        $name = json_decode($carrera, true);
        return view ('planes.planes')->with('data', $data)->with('id', $id)->with('name', $name); //se envian los datos de los planes mas el nombre de la carrera y su id

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function edit(Carrera $carrera)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_carrera'=>'required'

        ]);


        $query = DB::table('carreras')->where('id', $id)->update([
            'nombre'=>$request->input('nombre_carrera'),
            'facultad'=>$request->input('facultad'),
            'formacion'=>$request->input('formacion'),
            'tipo'=>$request->input('tipo'),
        ]);
        

        return back()->withSuccess('Carrera actualizada con éxito');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = DB::table('carreras')->where('id', $id)->delete();

        $query2= 'DELETE competencias, dimensions, aprendizajes, sabers, propuesta_modulos, propuesta_tiene_saber, modulos, modulo_tiene_prerrequisito, tempo_competencias, tempo_aprendizajes FROM competencias 
          INNER JOIN tempo_competencias ON tempo_competencias.competencia = competencias.id
          INNER JOIN dimensions ON dimensions.refCompetencia = competencias.id
          INNER JOIN aprendizajes ON aprendizajes.refDimension = dimensions.id
          INNER JOIN tempo_aprendizajes ON tempo_aprendizajes.aprendizaje = aprendizaje.id
          INNER JOIN sabers ON sabers.refAprendizaje = aprendizajes.id
          INNER JOIN propuesta_tiene_saber ON sabers.id = propuesta_tiene_saber.saber
          INNER JOIN propuesta_modulos  ON  propuesta_tiene_saber.propuesta_modulo = propuesta_modulos.id
          INNER JOIN modulos  ON  propuesta_modulos.id = modulos.refPropuesta
          INNER JOIN modulo_tiene_prerrequisito  ON  modulo.id = modulo_tiene_prerrequisito.modulo
          WHERE competencias.refCarrera = ?';

        $status = \DB::delete($query2, array($id));
        
        return back()->withSuccess('Carrera eliminada con éxito');
    }



}
