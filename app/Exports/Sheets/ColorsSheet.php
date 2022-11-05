<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Color;

class ColorsSheet implements FromQuery, WithTitle, ShouldAutoSize, WithHeadings
{

    public function headings(): array
    {
        return [
           'Наименование','ID Цвета'
        ];
    }

    public function query()
    {
        return Color::join('translates', 'translates.id','colors.title')->select('translates.ru','colors.id');
    }

    public function title(): string
    {
        return 'Цвета';
    }
}