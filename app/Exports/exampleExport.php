<?php

namespace App\Exports;

use App\Exports\Sheets\PriceTypeSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\ProductsSheet;
use App\Exports\Sheets\CategoriesSheet;
use App\Exports\Sheets\BrandsSheet;
use App\Exports\Sheets\ColorsSheet;
use App\Exports\Sheets\CountrySheet;
use App\Exports\Sheets\FeaturesSheet;
use App\Exports\Sheets\FiltersSheet;
use App\Exports\Sheets\TypeSizeSheet;
use App\Exports\Sheets\SizeItemsSheet;

class exampleExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets['products'] = new ProductsSheet();
        $sheets['categories'] = new CategoriesSheet();
        $sheets['brands'] = new BrandsSheet();
        $sheets['colors'] = new ColorsSheet();
        $sheets['country'] = new CountrySheet();
        $sheets['price_types'] = new PriceTypeSheet();

        return $sheets;
    }
}
