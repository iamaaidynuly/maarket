<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Size;

class TypeSizeSheet implements FromQuery, WithTitle, ShouldAutoSize, WithHeadings
{

    public function headings(): array
    {
        return [
           'Наименование', 'ID Тип размера'
        ];
    }

    public function query()
    {
        return Size::join('translates', 'translates.id', 'sizes.title')->select('translates.ru as name', 'sizes.id');
    }

    public function title(): string
    {
        return 'Тип размера';
    }
}