<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Feature;

class FeaturesSheet implements FromQuery, WithTitle, ShouldAutoSize, WithHeadings
{

    public function headings(): array
    {
        return [
           'Наименование','Значение', 'ID Характеристики'
        ];
    }

    public function query()
    {
            $data = Feature::join('feature_items', 'feature_items.feature_id', 'features.id')->select('features.title','feature_items.item_name','feature_items.id');
            return $data;
        }

    public function title(): string
    {
        return 'Характеристики';
    }
}
