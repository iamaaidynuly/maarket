<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\MailSheet;


class mailExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets['mail'] = new MailSheet();
        return $sheets;
    }
}
