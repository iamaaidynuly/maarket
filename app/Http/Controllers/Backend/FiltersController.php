<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\CategoryFilterRelations;
use App\Models\Filter;
use App\Models\FilterItems;
use App\Models\ProductFilterRelations;
use App\Models\Translate;
use Illuminate\Http\Request;

class FiltersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getFilters']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        $filters = Filter::latest()->paginate($perPage);
        return view('filters.index', compact('filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('filters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $requestData = $request->all();
        //dd($requestData);

        $title = new Translate();
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        $title->save();

        $filter = new Filter();
        $filter->title = $title->id;

        if ($filter->save()) {
            return redirect('admin/filters')->with('flash_message', 'Фильтр добавлен');
        } else {
            return redirect('admin/filters')->with('error', 'Ошибка при добавлении');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $filter = Filter::findOrFail($id);

        return view('filters.show', compact('filter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $filter = Filter::findOrFail($id);
        $filter_items = FilterItems::where('filter_id', $id)->get();
        return view('filters.edit', compact('filter', 'filter_items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $filter = Filter::findOrFail($id);

        $title = Translate::find($filter->title);
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        $title->update();

        return redirect('admin/filters')->with('flash_message', 'Фильтр обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Filter::destroy($id);

        $filter_items = FilterItems::where('filter_id', $id)->get();

        foreach ($filter_items as $value) {

            $item_delete = Translate::find($value->title);
            $item_delete->delete();
            $value->delete();
            $pf_relations = ProductFilterRelations::where('filter_item_id', $value->id)->get();
            foreach ($pf_relations as $rel_item) {
                $rel_item->delete();
            }
        }

        $cf_relarions = CategoryFilterRelations::where('filter_id', $id)->get();

        if ($cf_relarions) {
            foreach ($cf_relarions as $item) {
                $item->delete();
            }
        }


        return redirect('admin/filters')->with('flash_message', 'Фильтр удален');
    }

    public function getFilters(Request $request)
    {
        $filters = Filter::join('c_f_relations', 'c_f_relations.filter_id', 'filters.id')
            ->join('translates', 'translates.id', 'filters.title')
            ->where('c_f_relations.category_id', request('category_id'))
            ->select('filters.id', 'filters.title', 'translates.ru')
            ->orderBy('translates.ru', 'ASC')
            ->get();
        return view('products.filters_option', compact('filters'));
    }

    public function filterItems($id)
    {
        $filter = Filter::findOrFail($id);
        $filter_items = FilterItems::where('filter_id', $id)->get();
        // dd($id, $filter,$filter_items);
        return view('filters.filter_items', compact('filter', 'filter_items'));
    }

    public function filterItemsStore(Request $request, $id)
    {
        $requestData = $request->all();

        $filter_name = new Translate();
        $filter_name->ru = $requestData['filter_item']['ru'];
        $filter_name->en = $requestData['filter_item']['en'];

        if ($filter_name->save()) {
            $filter_item = new FilterItems();
            $filter_item->title = $filter_name->id;
            $filter_item->filter_id = $id;
            if ($filter_item->save()) {
                return redirect('admin/filter-items/' . $id)->with('flash_message', 'Значение добавлено');
            } else {
                return redirect('admin/filter-items/' . $id)->with('error', 'Возникла ошибка при добавлении');
            }
        }
    }

    public function filterItemsUpdate(Request $request, $id)
    {
        $requestData = $request->all();

        $filter_item = FilterItems::find($id);

        $filter_name = Translate::where('id', $filter_item->title)->first();

        $filter_name->ru = $requestData['filter_item']['ru'];
        $filter_name->en = $requestData['filter_item']['en'];

        if ($filter_name->update()) {
            return redirect('admin/filter-items/' . $filter_item->getParent->id)->with('flash_message', 'Значение добавлено');
        } else {
            return redirect('admin/filter-items/' . $filter_item->getParent->id)->with('error', 'Возникла ошибка при добавлении');
        }
    }

    public function filterItemsDelete($id)
    {
        $filter_item = FilterItems::find($id);

        $filter_name = Translate::where('id', $filter_item->title)->first();

        if ($filter_name->delete()) {

            $p_f_relations = ProductFilterRelations::where('filter_item_id', $id)->get();
            if ($p_f_relations) {
                foreach ($p_f_relations as $item) {
                    $item->delete();
                }
            }

            if ($filter_item->delete()) {
                return redirect('admin/filter-items/' . $filter_item->getParent->id)->with('flash_message', 'Значение удалено');
            } else {
                return redirect('admin/filter-items/' . $filter_item->getParent->id)->with('error', 'Возникла ошибка при удалении');
            }
        }
    }

}
