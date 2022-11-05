<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Brand;

class BrandsSheet implements FromQuery, WithTitle, ShouldAutoSize, WithHeadings
{

    public function headings(): array
    {
        return [
           'Наименование', 'ID Бренда'
        ];
    }

    public function query()
    {
        return Brand::join('translates', 'translates.id', 'brands.title')->select('translates.ru as name', 'brands.id');
    }

    public function title(): string
    {
        return 'Бренды';
    }
}