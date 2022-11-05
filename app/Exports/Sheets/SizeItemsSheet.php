<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Size;
use App\Models\SizeItems;

class SizeItemsSheet implements FromQuery, WithTitle, ShouldAutoSize, WithHeadings
{

    public function headings(): array
    {
        return [
           'Наименование', 'ID Тип размера', 'ID Размера'
        ];
    }

    public function query()
    {
        return SizeItems::join('translates', 'translates.id', 'size_items.title')->select('translates.ru as name', 'size_items.size_id', 'size_items.id');
    }

    public function title(): string
    {
        return 'Размеры';
    }
}