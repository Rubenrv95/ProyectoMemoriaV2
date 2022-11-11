<?php


namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class CompetenciasSheets implements FromCollection, WithTitle
{
    protected $id;


    public function __construct(int $id)
    {
        $this->id = $id;
    }


    public function collection()
    {
        return DB::table('competencias')->select('competencias.orden', 'competencias.descripcion')->where('refcarrera', $this->id)->get();
    }

    public function title(): string
    {
        return 'Competencias';
    }
}

