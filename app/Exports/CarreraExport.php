<?php

namespace App\Exports;

use App\Models\Carrera;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CarreraExport implements WithMultipleSheets
{

    use Exportable;
    protected $id;


    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        return [new Sheets\CompetenciasSheets($this->id), new Sheets\AprendizajesSheets($this->id), new Sheets\SaberesSheets($this->id)];
    }
}
