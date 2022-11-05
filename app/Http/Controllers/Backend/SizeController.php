<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Models\Translate;
use App\Models\SizeItems;
use App\Models\ProductSizeRelations;

class SizeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = 25;

        $size = Size::latest()->paginate($perPage);


        return view('size.index', compact('size'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('size.create');
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

        $size = new Size();
        $size->title = $title->id;

        if ($size->save()) {
            return redirect('admin/size')->with('flash_message', 'Добавлен!');
        } else {
            return redirect('admin/size')->with('error', 'Ошибка при добавлении');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $size = Size::findOrFail($id);

        return view('size.show', compact('size'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $size = Size::findOrFail($id);

        return view('size.edit', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $size = Size::findOrFail($id);

        $title = Translate::find($size->title);
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        $title->update();

        return redirect('admin/size')->with('flash_message', 'Обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Size::destroy($id);

        return redirect('admin/size')->with('flash_message', 'Удален!');
    }

    public function getSize(Request $request)
    {
        $sizes = SizeItems::join('translates', 'translates.id', 'size_items.title')
            ->where('size_items.size_id', request('size_id'))
            ->select('size_items.id', 'size_items.title', 'translates.ru')
            ->orderBy('translates.ru')
            ->get();
        //dd($sizes);
        return view('products.size_items_option', compact('sizes'));
    }

    // public function getFilters(Request $request)
    // {
    //     $filters = Filter::join('translates', 'translates.id', 'filters.title')
    //     ->where('size_items.size_id', request('size_id'))
    //     ->select('filters.id', 'filters.title','translates.ru')
    //     ->orderBy('translates.ru', 'ASC')
    //     ->get();
    //     return view('products.filters_option', compact('filters'));
    // }

    public function sizeItems($id)
    {
        $size = Size::findOrFail($id);
        $size_items = SizeItems::where('size_id', $id)->get();
        // dd($id, $filter,$filter_items);
        return view('size.size_items', compact('size', 'size_items'));
    }

    public function sizeItemsStore(Request $request, $id)
    {
        $requestData = $request->all();

        $size_name = new Translate();
        $size_name->ru = $requestData['size_item']['ru'];
        $size_name->en = $requestData['size_item']['en'];

        if ($size_name->save()) {
            $size_item = new SizeItems();
            $size_item->title = $size_name->id;
            $size_item->size_id = $id;
            if ($size_item->save()) {
                return redirect('admin/size-items/' . $id)->with('flash_message', 'Значение добавлено');
            } else {
                return redirect('admin/size-items/' . $id)->with('error', 'Возникла ошибка при добавлении');
            }
        }
    }

    public function sizeItemsUpdate(Request $request, $id)
    {
        $requestData = $request->all();

        $size_item = SizeItems::find($id);

        $size_name = Translate::where('id', $size_item->title)->first();

        $size_name->ru = $requestData['size_item']['ru'];
        $size_name->en = $requestData['size_item']['en'];

        if ($size_name->update()) {
            return redirect('admin/size-items/' . $size_item->getParent->id)->with('flash_message', 'Значение добавлено');
        } else {
            return redirect('admin/size-items/' . $size_item->getParent->id)->with('error', 'Возникла ошибка при добавлении');
        }
    }

    public function sizeItemsDelete($id)
    {
        $size_item = SizeItems::find($id);

        $size_name = Translate::where('id', $size_item->title)->first();

        if ($size_name->delete()) {

            $p_s_relations = ProductSizeRelations::where('size_item_id', $id)->get();
            if ($p_s_relations) {
                foreach ($p_s_relations as $item) {
                    $item->delete();
                }
            }

            if ($size_item->delete()) {
                return redirect('admin/size-items/' . $size_item->getParent->id)->with('flash_message', 'Значение удалено');
            } else {
                return redirect('admin/size-items/' . $size_item->getParent->id)->with('error', 'Возникла ошибка при удалении');
            }
        }
    }
}
