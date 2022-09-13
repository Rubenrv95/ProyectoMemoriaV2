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

    public function createForm()
    {
        return view('crearCarrera');
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
        $carrera = Carrera::find($carrera);

        //$carrera= json_encode($carrera, true);

        $newCarrera = $carrera->replicate()->fill(
            [
                'nombre' => $request->input('nombre_carrera_nueva'),
                'facultad' => $request->input('facultad_nueva'),
                'formacion' => $request->input('formacion_nueva'),
                'tipo' => $request->input('tipo_nuevo'),
            ]
        );
        //$newTask->project_id = 16; // the new project_id
        $newCarrera->save();

        


        return back();
    }

    public function createPDF($carrera) {
        $competencia = DB::table('competencias')->where('refCarrera', $carrera)->get();
        $aprendizaje = DB::table('aprendizajes')->leftJoin('competencias', 'aprendizajes.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $carrera)->select('aprendizajes.*', 'competencias.Descripcion')->get();
        $saber_conocer = DB::table('saber_conocers')->leftJoin('aprendizajes', 'saber_conocers.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('competencias', 'aprendizajes.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $carrera)->select('saber_conocers.*', 'aprendizajes.Descripcion_aprendizaje', 'competencias.refCarrera')->get();
        $saber_hacer = DB::table('saber_hacers')->leftJoin('aprendizajes', 'saber_hacers.refAprendizaje', '=', 'aprendizajes.id')->leftJoin('competencias', 'aprendizajes.refCompetencia', '=', 'competencias.id')->where('competencias.refCarrera', '=', $carrera)->select('saber_hacers.*', 'aprendizajes.Descripcion_aprendizaje', 'competencias.refCarrera')->get();
        $competencia = json_decode($competencia, true);
        $aprendizaje = json_decode($aprendizaje, true);
        $saber_conocer = json_decode($saber_conocer, true);
        $saber_hacer = json_decode($saber_hacer, true);
        $pdf = PDF::loadView('descargas.reporte', compact('carrera', 'competencia', 'aprendizaje', 'saber_conocer', 'saber_hacer'));
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

        $query2= 'DELETE competencias, dimensions FROM competencias 
          INNER JOIN dimensions ON dimensions.refCompetencia = competencias.id
          WHERE competencias.refCarrera = ?';

        $status = \DB::delete($query2, array($id));
        
        return back()->withSuccess('Carrera eliminada con éxito');
    }



}
