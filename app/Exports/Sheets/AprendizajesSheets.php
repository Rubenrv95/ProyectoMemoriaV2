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
        ->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
        ->where('competencias.refcarrera', '=',  $this->id)
        ->select('competencias.descripcion', 'dimensions.descripcion_dimension', 'aprendizajes.descripcion_aprendizaje', 'aprendizajes.nivel_aprend')
        ->get();
    }

    public function title(): string
    {
        return 'Aprendizajes';
    }
}

