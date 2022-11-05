<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class Imports implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
    public function model(array $row)
    {
        return new Product([
            'article'     => $row[0],
            'brand'    => $row[1],
            'category'    => $row[2],
            'name'    => $row[3],
            'price'    => $row[4],
            'criterion'    => $row[5],
        ]);
    }
}
