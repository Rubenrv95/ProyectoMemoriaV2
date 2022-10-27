<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Exports\CarreraExport;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use App\Http\Controllers\PlanController;
use PDF;
use  Maatwebsite\Excel\Facades\Excel;


class CarreraController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Se muestra la vista de carreras
     *
     */
    public function index()
    {
        $data = Carrera::orderBy('nombre')->get(); 
        return view ('/carreras', ['carrera'=>$data]);
    }

    /**
     * Se crea una carrera
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

    /**
     * Se crea un documento PDF con la información solicitada
     */
    public function createPDF($carrera) {
        $competencia = DB::table('competencias')->where('refCarrera', $carrera)->get();
        $tempo_competencia = DB::table('tempo_competencias')
        ->leftJoin('competencias', 'competencias.id', '=', 'tempo_competencias.competencia')
        ->select('tempo_competencias.*', 'competencias.Orden', 'competencias.Descripcion')
        ->where('competencias.refCarrera', $carrera)
        ->get();
        
        $aprendizaje = DB::table('aprendizajes')
        ->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')
        ->where('competencias.refCarrera', '=', $carrera)
        ->select('aprendizajes.*', 'competencias.Descripcion', 'competencias.Orden as OrdenComp', 'competencias.id as idComp', 'dimensions.Descripcion_dimension', 'dimensions.Orden', 'dimensions.id as idDim')
        ->get();
        $tempo_aprendizaje = DB::table('tempo_aprendizajes')
        ->leftJoin('aprendizajes', 'aprendizajes.id', '=', 'tempo_aprendizajes.aprendizaje')
        ->leftJoin('dimensions', 'dimensions.id', '=', 'aprendizajes.refDimension')
        ->leftJoin('competencias', 'competencias.id', '=', 'dimensions.refCompetencia')
        ->select('tempo_aprendizajes.*', 'aprendizajes.Descripcion_aprendizaje', 'aprendizajes.Nivel_aprend', 'dimensions.Descripcion_dimension', 'dimensions.Orden', 'competencias.Orden as OrdenComp', 'competencias.Descripcion')
        ->where('competencias.refCarrera', $carrera)->get();
        
        $saber = DB::table('sabers')
        ->leftJoin('aprendizajes', 'sabers.refAprendizaje', '=', 'aprendizajes.id')
        ->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')
        ->where('competencias.refCarrera', '=', $carrera)
        ->select('sabers.*', 'aprendizajes.Descripcion_aprendizaje', 'dimensions.Descripcion_dimension', 'dimensions.Orden as OrdenDim', 'competencias.Orden as OrdenComp', 'competencias.Descripcion')
        ->get();

        $coleccion= collect(
            DB::table('modulos')
           ->leftJoin('propuesta_modulos', 'modulos.refPropuesta', '=', 'propuesta_modulos.id')
           ->leftJoin('propuesta_tiene_saber', 'propuesta_tiene_saber.propuesta_modulo', '=', 'propuesta_modulos.id')
           ->leftJoin('sabers', 'propuesta_tiene_saber.saber', '=', 'sabers.id')
           ->leftJoin('aprendizajes', 'sabers.refAprendizaje', '=', 'aprendizajes.id')
           ->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')
           ->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')
           ->where('competencias.refCarrera', '=', $carrera)
           ->select('modulos.*', 'propuesta_modulos.Nombre_modulo', 'propuesta_modulos.Semestre')
           ->orderBy('propuesta_modulos.Semestre')
           ->get()
       );

        $modulo = $coleccion->unique('id');
        $modulo->values()->all();

        $carrera_seleccionada = DB::table('carreras')->where('id', $carrera)->get();

        $competencia = json_decode($competencia, true);
        $tempo_competencia = json_decode($tempo_competencia, true);
        $aprendizaje = json_decode($aprendizaje, true);
        $tempo_aprendizaje = json_decode($tempo_aprendizaje, true);
        $saber = json_decode($saber, true);
        $modulo = json_decode($modulo, true);
        $carrera_seleccionada = json_decode($carrera_seleccionada, true);

        $pdf = PDF::loadView('descargas.reporte', compact('carrera_seleccionada', 'competencia', 'aprendizaje', 'saber', 'tempo_competencia', 'tempo_aprendizaje', 'modulo'));
        return $pdf->download('reporte.pdf');
      }

      /**
       * Se crea un Excel con la información solicitada
       */
      public function exportExcel($carrera) {

        return (new CarreraExport($carrera))->download('tablas.xlsx');
      }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

  
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
     * Se actualiza una carrera
     * @param id, id de la carrera
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
     * Se elimina una carrera
     * @param id, id de la carrera
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
