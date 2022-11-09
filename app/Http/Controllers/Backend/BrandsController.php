<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Translate;
use Illuminate\Support\Facades\Storage;
use App\Models\Brand;
use App\Models\BrandItems;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getBrand']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = 25;
        $brands = Brand::latest()->paginate($perPage);
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('brands.create');
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
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
            [
                'image.image' => 'Файл должен быть картинкой',
                'image.required' => 'Загрузите изображение',
                'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'image.max' => 'Размер файла не может превышать 2МБ',
            ]);
        $requestData = $request->all();
        if ($request->hasFile('image')) {
            $name = time() . '.' . $requestData['image']->extension();
            $path = 'brand';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');
        }

        if ($request->hasFile('table_size')) {

            $name = time() . '.' . $requestData['table_size']->extension();
            $path = 'brand';
            $requestData['table_size'] = $request->file('table_size')->storeAs($path, $name, 'static');
        }

        $title = new Translate();
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        $title->save();
        $content = new Translate();
        $content->ru = $requestData['content']['ru'];
        $content->en = $requestData['content']['en'];
        $content->kz = $requestData['content']['kz'];
        $content->save();

        $brand = new Brand();
        $brand->title = $title->id;
        $brand->slug = Str::slug($requestData['title']['ru']);
        $brand->content = $content->id;
        $brand->image = $requestData['image'];
        $brand->save();

        return redirect('admin/brands')->with('flash_message', 'Бренд добавлен');
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
        $brand = Brand::findOrFail($id);

        return view('brands.show', compact('brand'));
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
        $brand = Brand::findOrFail($id);

        return view('brands.edit', compact('brand'));
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
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
            [
                'image.image' => 'Файл должен быть картинкой',
                'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'image.max' => 'Размер файла не может превышать 2МБ',
            ]);

        $requestData = $request->all();

        $brand = Brand::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($brand->image != null) {
                Storage::disk('static')->delete($brand->image);
            }
            $name = time() . '.' . $requestData['image']->extension();
            $path = 'brand';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');

            $brand->image = $requestData['image'];
        }
        $title = Translate::find($brand->title);
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        $title->update();
        $content = Translate::find($brand->content);
        $content->ru = $requestData['content']['ru'];
        $content->en = $requestData['content']['en'];
        $content->kz = $requestData['content']['kz'];
        $content->update();
        $brand->update();

        return redirect('admin/brands')->with('flash_message', 'Бренд сохранен');
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
        $brand = Brand::findOrFail($id);

        if ($brand->image != null) {
            Storage::disk('static')->delete($brand->image);
        }
        if ($brand->table_size != null) {
            Storage::disk('static')->delete($brand->table_size);
        }

        $title = Translate::find($brand->title);
        $title->delete();

        $content = Translate::find($brand->content);
        $content->delete();

        $brand->delete();

        return redirect('admin/brands')->with('flash_message', 'Бренд удален');
    }

    public function editSeo($id)
    {
        $brands = Brand::findOrFail($id);
        return view('brands.meta_seo', compact('brands'));
    }

    public function updateSeo(Request $request, $id)
    {
        $requestData = $request->all();
        $brands = Brand::findOrFail($id);

        $meta_title = Translate::where('id', $brands->meta_title)->first();
        if ($meta_title) {
            $meta_title->ru = $requestData['meta_title']['ru'];
            $meta_title->en = $requestData['meta_title']['en'];
            $meta_title->kz = $requestData['meta_title']['kz'];
            $meta_title->update();
        } else {
            $create_title = new Translate();
            $create_title->ru = $requestData['meta_title']['ru'];
            $create_title->en = $requestData['meta_title']['en'];
            $create_title->kz = $requestData['meta_title']['kz'];
            $create_title->save();
            $brands->meta_title = $create_title->id;
            $brands->update();
        }

        $meta_description = Translate::where('id', $brands->meta_description)->first();
        if ($meta_description) {
            $meta_description->ru = $requestData['meta_description']['ru'];
            $meta_description->en = $requestData['meta_description']['en'];
            $meta_description->kz = $requestData['meta_description']['kz'];
            $meta_description->update();
        } else {
            $create_description = new Translate();
            $create_description->ru = $requestData['meta_description']['ru'];
            $create_description->en = $requestData['meta_description']['en'];
            $create_description->kz = $requestData['meta_description']['kz'];
            $create_description->save();
            $brands->meta_description = $create_description->id;
            $brands->update();
        }

        return redirect('admin/brands')->with('flash_message', 'Мета данные сохранены');
    }

    public function getBrand(Request $request)
    {
        $brand_items = BrandItems::join('translates', 'translates.id', 'brand_items.title')
            ->where('brand_items.brand_id', request('brand_id'))
            ->select('brand_items.id', 'brand_items.title', 'translates.ru')
            ->orderBy('translates.ru', 'ASC')
            ->get();
        //dd($sizes);
        return view('products.brand_items_option', compact('brand_items'));
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

    public function brandItems($id)
    {
        $brand = Brand::findOrFail($id);
        $brand_items = BrandItems::where('brand_id', $id)->get();
        // dd($id, $filter,$filter_items);
        return view('brands.brand_items', compact('brand', 'brand_items'));
    }


    public function brandItemsStore(Request $request, $id)
    {
        $requestData = $request->all();

        $brand_name = new Translate();
        $brand_name->ru = $requestData['brand_item']['ru'];
        $brand_name->en = $requestData['brand_item']['en'];

        if ($brand_name->save()) {
            $brand_item = new BrandItems();
            $brand_item->title = $brand_name->id;
            $brand_item->brand_id = $id;
            if ($brand_item->save()) {
                return redirect('admin/brand-items/' . $id)->with('flash_message', 'Значение добавлено');
            } else {
                return redirect('admin/brand-items/' . $id)->with('error', 'Возникла ошибка при добавлении');
            }
        }
    }

    public function brandItemsUpdate(Request $request, $id)
    {
        $requestData = $request->all();

        $brand_item = BrandItems::find($id);

        $brand_name = Translate::where('id', $brand_item->title)->first();

        $brand_name->ru = $requestData['brand_item']['ru'];
        $brand_name->en = $requestData['brand_item']['en'];

        if ($brand_name->update()) {
            return redirect('admin/brand-items/' . $brand_item->getParent->id)->with('flash_message', 'Значение добавлено');
        } else {
            return redirect('admin/brand-items/' . $brand_item->getParent->id)->with('error', 'Возникла ошибка при добавлении');
        }
    }

    public function brandItemsDelete($id)
    {
        //dd('test');
        $brand_item = BrandItems::find($id);

        $brand_name = Translate::where('id', $brand_item->title)->first();

        if ($brand_name->delete()) {

            if ($brand_item->delete()) {
                return redirect('admin/brand-items/' . $brand_item->getParent->id)->with('flash_message', 'Значение удалено');
            } else {
                return redirect('admin/brand-items/' . $brand_item->getParent->id)->with('error', 'Возникла ошибка при удалении');
            }
        }
    }
}
