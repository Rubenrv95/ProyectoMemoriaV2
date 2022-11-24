<?php


namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class SaberesSheets implements FromCollection, WithTitle
{
    protected $id;


    public function __construct(int $id)
    {
        $this->id = $id;
    }


    public function collection()
    {
        return DB::table('sabers')
        ->leftJoin('aprendizajes', 'sabers.refaprendizaje', '=', 'aprendizajes.id')
        ->leftJoin('dimensions', 'aprendizajes.refdimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refcompetencia', '=', 'competencias.id')
        ->where('competencias.refcarrera', '=',  $this->id)
        ->select('sabers.descripcion_saber', 'sabers.tipo', 'sabers.nivel', 'aprendizajes.descripcion_aprendizaje', 'dimensions.descripcion_dimension', 'competencias.descripcion')
        ->get();
    }

    public function title(): string
    {
        return 'Saberes';
    }
}

