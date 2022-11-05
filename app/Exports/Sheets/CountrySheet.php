<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Country;

class CountrySheet implements FromQuery, WithTitle, ShouldAutoSize, WithHeadings
{

    public function headings(): array
    {
        return [
           'Наименование','ID Страны'
        ];
    }

    public function query()
    {
        return Country::join('translates', 'translates.id','countries.title')->select('translates.ru','countries.id');
    }

    public function title(): string
    {
        return 'Страны';
    }
}