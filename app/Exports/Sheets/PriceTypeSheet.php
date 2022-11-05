<?php
declare(strict_types=1);

namespace App\Exports\Sheets;

use App\Models\PriceType;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Country;

class PriceTypeSheet implements FromQuery, WithTitle, ShouldAutoSize, WithHeadings
{

    public function headings(): array
    {
        return [
            'Название','ID Типа'
        ];
    }

    public function query()
    {
        return PriceType::select('name', 'id');
    }

    public function title(): string
    {
        return 'Типы цен';
    }
}
