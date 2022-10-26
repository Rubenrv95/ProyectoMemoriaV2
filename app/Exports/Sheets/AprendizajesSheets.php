<?php


namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class AprendizajesSheets implements FromCollection, WithTitle
{
    protected $id;


    public function __construct(int $id)
    {
        $this->id = $id;
    }


    public function collection()
    {
        return DB::table('aprendizajes')
        ->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')
        ->where('competencias.refCarrera', '=',  $this->id)
        ->select('competencias.Descripcion', 'dimensions.Descripcion_dimension', 'aprendizajes.Descripcion_aprendizaje', 'aprendizajes.Nivel_aprend')
        ->get();
    }

    public function title(): string
    {
        return 'Aprendizajes';
    }
}

