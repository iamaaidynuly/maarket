<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Filter;

class FiltersSheet implements FromQuery, WithTitle, ShouldAutoSize, WithHeadings
{

    public function headings(): array
    {
        return [
           'Наименование','Значения', 'ID Фильтра'
        ];
    }

    public function query()
    {
            $data = Filter::join('filter_items', 'filter_items.filter_id', 'filters.id')->select('filters.title','filter_items.title_item','filter_items.id');
            return $data;
        }

    public function title(): string
    {
        return 'Фильтры';
    }
}
