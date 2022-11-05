<?php

namespace App\Exports\Sheets;

use App\Http\Resources\ProductFeatureResource;
use App\Models\ProductFeature;
use App\Models\ProductPriceTypes;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Product;
use App\Models\Color;
use App\Models\SizeItems;
use App\Models\FilterItems;

class ProductsSheet implements FromView, WithTitle, ShouldAutoSize
{
    public function view(): View
    {
        $products = Product::query()->join('translates as title', 'title.id', 'products.title')
            ->join('translates as description', 'description.id', 'products.description')
            ->select('products.id as idd', 'title.ru as title_ru', 'title.en as title_en', 'title.kz as title_kz', 'description.ru as desc_ru', 'description.en as desc_en', 'description.kz as desc_kz', 'products.artikul', 'products.best', 'products.new', 'products.stock', 'products.price', 'products.sale', 'products.brand_id', 'products.country_id', 'products.category_id', 'products.size_id')
            ->first();
        $data_color = Color::join('color_relations', 'color_relations.color_id', 'colors.id')->where('color_relations.product_id', $products->idd)
            ->select('color_relations.color_id as color_id')
            ->get();
        $color_id = '';
        foreach ($data_color as $item) {
            $color_id = $color_id . $item->color_id . ';';
        }

        $data_size = SizeItems::join('p_s_relations', 'p_s_relations.size_item_id', 'size_items.id')->where('p_s_relations.product_id', $products->idd)
            ->select('p_s_relations.size_item_id as size_item_id')
            ->get();
        $size_item_id = '';
        foreach ($data_size as $item_s) {
            $size_item_id = $size_item_id . $item_s->size_item_id . ';';
        }

        $data_filter = FilterItems::join('p_f_relations', 'p_f_relations.filter_item_id', 'filter_items.id')->where('p_f_relations.product_id', $products->idd)
            ->select('p_f_relations.filter_item_id as filter_item_id')
            ->get();
        $filter_item_id = '';
        foreach ($data_filter as $item_f) {
            $filter_item_id = $filter_item_id . $item_f->filter_item_id . ';';
        }

        $feature = ProductFeature::join('translates as type', 'type.id', 'product_features.type')->join('translates as purpose', 'purpose.id', 'product_features.purpose')
            ->join('translates as size', 'size.id', 'product_features.size')
            ->join('translates as quantity', 'quantity.id', 'product_features.quantity')
            ->select('product_features.id', 'product_features.product_id', 'type.kz as type_kz', 'type.ru as type_ru', 'type.en as type_en', 'purpose.kz as purpose_kz', 'purpose.en as purpose_en',
                'purpose.ru as purpose_ru', 'size.kz as size_kz', 'size.ru as size_ru', 'size.en as size_en', 'quantity.kz as quantity_kz', 'quantity.ru as quantity_ru', 'quantity.en as quantity_en'
            )->first();

        $prices = ProductPriceTypes::where('product_id', $products->id)->get();

        return view('exports.color', [
            'color_id' => substr($color_id, 0, -1),
            'size_item_id' => substr($size_item_id, 0, -1),
            'filter_item_id' => substr($filter_item_id, 0, -1),
            'product' => $products,
            'feature' => $feature,
        ]);
    }

    public function title(): string
    {
        return 'Продукты';
    }
}
