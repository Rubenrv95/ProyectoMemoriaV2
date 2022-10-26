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
        ->leftJoin('aprendizajes', 'sabers.refAprendizaje', '=', 'aprendizajes.id')
        ->leftJoin('dimensions', 'aprendizajes.refDimension', '=', 'dimensions.id')
        ->leftJoin('competencias', 'dimensions.refCompetencia', '=', 'competencias.id')
        ->where('competencias.refCarrera', '=',  $this->id)
        ->select('sabers.Descripcion_saber', 'sabers.Tipo', 'sabers.Nivel', 'aprendizajes.Descripcion_aprendizaje', 'dimensions.Descripcion_dimension', 'competencias.Descripcion')
        ->get();
    }

    public function title(): string
    {
        return 'Saberes';
    }
}

