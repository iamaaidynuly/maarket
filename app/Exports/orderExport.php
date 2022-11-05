<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\OrderSheet;


class orderExport implements WithMultipleSheets
{
    use Exportable;

    var $ot;
    var $do;

    function __construct($ot, $do)
    {
        $this->ot = $ot;
        $this->do = $do;
    }


    public function sheets(): array
    {
        $sheets['order'] = new OrderSheet($this->ot, $this->do);

        return $sheets;
    }
}
