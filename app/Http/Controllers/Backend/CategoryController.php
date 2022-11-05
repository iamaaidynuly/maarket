<?php

namespace App\Http\Controllers\Backend;

use App\Models\CategoryFilterRelations;
use App\Http\Controllers\Controller;
use App\Models\ApiDb;
use App\Models\Product;
use App\Models\Translate;
use App\Models\Category;
use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Filter;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
        $keyword = $request->get('parent_id');
        $perPage = 25;
        $parent = '';
        if (!empty($keyword)) {
            $parent_name = Category::find($keyword);
            $category = Category::where('parent_id', $keyword)
                ->orderBy('menu_position', 'ASC')->latest()->paginate($perPage);
            $parent = Category::where('id', $keyword)->first();
        } else {
            $category = Category::whereNull('parent_id')->orderBy('position')->orderBy('menu_position', 'ASC')->latest()->paginate($perPage);
        }

        return view('category.index', compact('category', 'parent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        if (request('parent_id')) {
            $category = Category::find(request('parent_id'));

            if ($category->getProducts->count() > 0) {
                return redirect('admin/category?parent_id=' . request('parent_id'))->with('error', 'Сначала удалите все товары категории');
            }
        }

        $filters = Filter::all();
        $filter_arr[] = NULL;
        return view('category.create', compact('filters', 'filter_arr'));
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
            'title.ru' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
            [
                'title.ru.required' => 'Заголовок обязательно для заполнения',
                'image.image' => 'Файл должен быть картинкой',
                'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'image.max' => 'Размер файла не может превышать 2МБ'
            ]);

        $requestData = $request->all();

        $category = new Category();

        if ($request->hasFile('image')) {

            $name = time() . '.' . $requestData['image']->extension();
            $path = 'category';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');

            $category->image = $requestData['image'];
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

        $category->title = $title->id;
        $category->content = $content->id;
        $category->slug = Str::slug($requestData['title']['ru']);
        if (isset($requestData['position'])) {
            $category->position = $requestData['position'];
        }

        if (isset($requestData['parent_id'])) {
            $category->parent_id = $requestData['parent_id'];
        }

        if ($category->save()) {
            foreach ($requestData['filters'] as $item) {
                $c_f_relations = new CategoryFilterRelations();
                $c_f_relations->filter_id = $item;
                $c_f_relations->category_id = $category->id;
                $c_f_relations->save();
            }
        }


        if (isset($requestData['parent_id'])) {
            return redirect('admin/category?parent_id=' . $requestData['parent_id'])->with('flash_message', 'Категория добавлена');
        } else {
            return redirect('admin/category')->with('flash_message', 'Категория добавлена');
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
        $category = Category::findOrFail($id);

        return view('category.show', compact('category'));
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
        $category = Category::findOrFail($id);
        $filter_arr[] = NULL;
        $filter_relations = CategoryFilterRelations::where('category_id', $id)->select('filter_id')->get()->toArray();
        foreach ($filter_relations as $item) {
            $filter_arr[] = $item['filter_id'];
        }
        $filters = Filter::all();

        return view('category.edit', compact('category', 'filters', 'filter_arr'));
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
            'title.ru' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
            [
                'title.ru.required' => 'Заголовок обязательно для заполнения',
                'image.image' => 'Файл должен быть картинкой',
                'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'image.max' => 'Размер файла не может превышать 2МБ'
            ]);

        $requestData = $request->all();

        $category = Category::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($category->image != null) {
                Storage::disk('static')->delete($category->image);
            }
            $name = time() . '.' . $requestData['image']->extension();
            $path = 'category';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');

            $category->image = $requestData['image'];
        }

        $title = Translate::find($category->title);
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        $title->update();

        $content = Translate::find($category->content);
        $content->ru = $requestData['content']['ru'];
        $content->en = $requestData['content']['en'];
        $content->kz = $requestData['content']['kz'];
        if ($content->update()) {
            $filters = CategoryFilterRelations::where('category_id', $id)->get();
            if ($filters) {
                foreach ($filters as $item) {
                    $item->delete();
                }
            }
            foreach ($requestData['filters'] as $item) {
                $c_f_relations = new CategoryFilterRelations();
                $c_f_relations->filter_id = $item;
                $c_f_relations->category_id = $category->id;
                $c_f_relations->save();
            }
        }

        $category->slug = Str::slug($requestData['title']['ru']);
        if (isset($requestData['position'])) {
            $category->position = $requestData['position'];
        }
        $category->parent_id = $requestData['parent_id'];

        $category->update();


        if ($request->input('parent_id')) {
            return redirect('admin/category?parent_id=' . $request->get('parent_id'))->with('flash_message', 'Категория сохранена');
        } else {
            return redirect('admin/category')->with('flash_message', 'Категория сохранена');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        if ($category->getProducts->count() > 0) {
            if ($category->parent_id != null) {
//                Product::where('category_id', $id)->delete();
                return redirect('admin/category?parent_id=' . $request->get('parent_id'))->with('error', 'Сначала удалите все товары категории');
            } else {
                return redirect('admin/category')->with('error', 'Сначала удалите все товары категории');
            }
        }
        if ($category->getChilds->count() > 0) {
            if ($category->parent_id != null) {
                return redirect('admin/category?parent_id=' . $request->get('parent_id'))->with('error', 'Сначала удалите все подкатегории');
            } else {
                return redirect('admin/category')->with('error', 'Сначала удалите все подкатегории');
            }
        }

        if ($category->image != null) {
            Storage::disk('static')->delete($category->image);
        }
        $title = Translate::find($category->title);
        $title->delete();

        $content = Translate::find($category->content);
        $content->delete();

        $category->delete();
        $filters = CategoryFilterRelations::where('category_id', $id)->get();
        if ($filters) {
            foreach ($filters as $item) {
                $item->delete();
            }
        }
        if ($category->parent_id != null) {
            return redirect('admin/category?parent_id=' . $category->parent_id)->with('flash_message', 'Подкатегория удалена');
        } else {
            return redirect('admin/category')->with('flash_message', 'Категория удалена');
        }
    }

    public function editSeo($id)
    {
        $category = Category::findOrFail($id);
        return view('category.meta_seo', compact('category'));
    }

    public function updateSeo(Request $request, $id)
    {
        $requestData = $request->all();
        $category = Category::findOrFail($id);

        $meta_title = Translate::where('id', $category->meta_title)->first();
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
            $category->meta_title = $create_title->id;
            $category->update();
        }

        $meta_description = Translate::where('id', $category->meta_description)->first();
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
            $category->meta_description = $create_description->id;
            $category->update();
        }

        // $data['ru']['categories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
        // ->whereNull('categories.parent_id')
        // ->select('categories.id','c_title.ru as title','categories.slug','categories.created_at')
        // ->orderBy('title', 'ASC')
        // ->get();
        // foreach ($data['ru']['categories'] as $item) {
        //     $item['subcategories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
        //     ->where('categories.parent_id', $item->id)
        //     ->select('categories.id','c_title.ru as title','categories.slug','categories.created_at')
        //     ->orderBy('title', 'ASC')->get();
        // }
        // $data['ru']['contacts'] = Contacts::select('contacts.id','phone_number','contacts.created_at')
        // ->orderBy('contacts.id', 'DESC')->first();

        // $data['en']['categories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
        // ->whereNull('categories.parent_id')
        // ->select('categories.id','c_title.en as title','categories.slug','categories.created_at')
        // ->orderBy('title', 'ASC')
        // ->get();
        // foreach ($data['en']['categories'] as $item) {
        //     $item['subcategories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
        //     ->where('categories.parent_id', $item->id)
        //     ->select('categories.id','c_title.en as title','categories.slug','categories.created_at')
        //     ->orderBy('title', 'ASC')->get();
        // }
        // $data['en']['contacts'] = Contacts::select('contacts.id','phone_number','contacts.created_at')
        // ->orderBy('contacts.id', 'DESC')->first();

        // $api_db = ApiDb::where('type', 'header')->where('lang', 'ru')->first();

        // if ($api_db) {
        //     $api_db->data = json_encode($data['ru']);
        //     $api_db->type = 'header';
        //     $api_db->update();

        //     $api_db_en = ApiDb::where('type', 'header')->where('lang', 'en')->first();
        //     $api_db_en->data = json_encode($data['en']);
        //     $api_db_en->type = 'header';
        //     $api_db_en->update();

        // }else{

        //     $api_db_ru = new ApiDb();
        //     $api_db_ru->data = json_encode($data['ru']);
        //     $api_db_ru->type = 'header';
        //     $api_db_ru->lang = 'ru';
        //     $api_db_ru->save();

        //     $api_db_en = new ApiDb();
        //     $api_db_en->data = json_encode($data['en']);
        //     $api_db_en->type = 'header';
        //     $api_db_en->lang = 'en';
        //     $api_db_en->save();
        // }

        return redirect('admin/category')->with('flash_message', 'Мета данные сохранены');
    }

    public function updatePosition(Request $request, $id)
    {
        $requestData = $request->all();
        $category = Category::findOrFail($id);
        $category->menu_position = $requestData['position'];
        $category->update();
        return $id;
    }
}
