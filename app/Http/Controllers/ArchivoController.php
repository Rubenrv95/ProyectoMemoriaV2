<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchivoController extends Controller
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


        $archivo =  DB::table('archivos')->where('refCarrera', $id_carrera)->get(); 
        $archivo = json_decode($archivo, true);

        return view('carreras.archivos')->with('carrera', $carrera)->with('archivo', $archivo);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'file' => 'required|max:2048'
         ]);

        $data = new Archivo();
        $file = $request->file;

        if ($request->file) {
            $filename=time().'.'.$file->getClientOriginalExtension();

            $request->file->move('assets', $filename);

            $data->nombre = $request->nombre;

            $data->archivo = $filename;

            $data->refcarrera = $id;

            $data->save();

            return back()->withSuccess('Archivo subido con éxito');;
        }
        
        return back()->withAlert('No se seleccionó un archivo');
        
    }


    public function download($id, Request $request, $file) {


        return response()->download(public_path('assets/'.$file));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function show(Archivo $archivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function edit(Archivo $archivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Archivo $archivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_carrera, $id_archivo)
    {
        $query = DB::table('archivos')->where('id', $id_archivo)->delete();

        return back()->withSuccess('Archivo eliminado con éxito');;
    }
}
