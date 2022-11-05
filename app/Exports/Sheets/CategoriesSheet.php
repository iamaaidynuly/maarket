<?php
namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Category;
use App\Models\Filter;
use Illuminate\Support\Facades\DB;

class CategoriesSheet implements FromView, WithTitle, ShouldAutoSize
{
    public function view(): View
    {
        
        $categories = Category::query()->whereNull('categories.parent_id')->leftJoin('categories as child', 'child.parent_id', 'categories.id')
        ->join('translates as parent_name','parent_name.id', 'categories.title')
        ->join('translates as child_name','child_name.id', 'child.title')
        ->select('parent_name.ru as parent_title', 'child_name.ru as child_title', DB::raw('(CASE WHEN child.id IS NULL THEN categories.id ELSE child.id END) AS id_cat'))->get();
        $data_key = 0;
        foreach($categories as $item){
            $data_filter = Filter::join('c_f_relations', 'c_f_relations.filter_id', 'filters.id')->where('c_f_relations.category_id', $item->id_cat)
            ->join('filter_items','filter_items.filter_id', 'filters.id')
            ->join('translates as filter_name', 'filter_name.id','filters.title')
            ->join('translates as filter_item', 'filter_item.id','filter_items.title')
            ->select('filter_name.ru as filter_name', 'filter_item.ru as filter_item','filters.id as filter_id','filter_items.id as item_id')
            ->get();
            foreach($data_filter as $data_item){
                $data[$data_key]['parent_title'] = $item->parent_title;
                $data[$data_key]['child_title'] = $item->child_title;
                $data[$data_key]['id_cat'] = $item->id_cat;
                $data[$data_key]['filter_name'] = $data_item->filter_name;
                $data[$data_key]['item_name'] = $data_item->filter_item;
                $data[$data_key]['item_filter_id'] = $data_item->item_id;
                $data_key++;
            }
        }
        
        return view('exports.category', [
            'data' => $data
        ]);
    }

    public function title(): string
    {
        return 'Категории';
    }
}
