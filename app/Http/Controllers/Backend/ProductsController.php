<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Imports\ProductImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryFilterRelations;
use App\Models\Color;
use App\Models\ColorRelations;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductPriceTypes;
use App\Models\Size;
use App\Models\ProductFilterRelations;
use App\Models\ProductSizeRelations;
use App\Models\ProductImages;
use App\Models\SizeItems;
use App\Models\BrandItems;
use App\Models\Admission;
use App\Models\Quantity;
use App\Models\Translate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;


class ProductsController extends Controller
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
        $data = $request->all();

        $category_id = $request->input('category_id');
        $brand_id = $request->input('brand_id');

        $categories = Category::join('translates', 'translates.id', 'categories.title')
            ->orderBy('translates.ru', 'DESC')
            ->whereNull('parent_id')
            ->select('categories.id as id', 'translates.ru as title')
            ->get();

        $brands = Brand::join('translates', 'translates.id', 'brands.title')->orderBy('translates.ru', 'DESC')->select('brands.id as id', 'translates.ru as title')->get();

        if ($request->input('paginate')) {
            $perPage = $request->get('paginate');
        } else {
            $perPage = 50;
        }

        $products = Product::when($category_id, function ($query, $category_id) {
            return $query->where('category_id', $category_id);
        })
            ->when($brand_id, function ($query, $brand_id) {
                return $query->where('brand_id', $brand_id);
            })
            ->orderBy('menu_position', 'ASC')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('products.index', compact('products', 'data', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $category = Category::join('translates', 'translates.id', 'categories.title')->whereNull('categories.parent_id')->select('categories.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $brands = Brand::join('translates', 'translates.id', 'brands.title')->select('brands.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $colors = Color::join('translates', 'translates.id', 'colors.title')->select('colors.id as id', 'translates.ru as title', 'colors.code')->orderBy('translates.ru')->get();
        $country = Country::join('translates', 'translates.id', 'countries.title')->select('countries.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $size = Size::join('translates', 'translates.id', 'sizes.title')->select('sizes.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $colors_arr[] = null;
        $filters_arr[] = null;
        $size_arr[] = null;

        return view('products.create', compact('category', 'brands', 'colors', 'country', 'colors_arr', 'filters_arr', 'size', 'size_arr'));
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
        $request->validate(
            [
                'title.ru' => 'required',
                'artikul' => 'required',
                'price' => 'required',
                //'short_description.ru' => 'required',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'brand_id' => 'required',
                'category_id' => 'required',
                'filters' => 'required',
//                'size_id' => 'required',
//                'size_items' => 'required'
            ],
            [
                'title.ru.required' => 'Заголовок обязательно для заполнения',
                //'short_description.ru.required' => 'краткое описание обязательно для заполнения',
                'images.image' => 'Файл должен быть картинкой',
                'images.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'images.max' => 'Размер файла не может превышать 2МБ',
                'main_image.image' => 'Файл должен быть картинкой',
                'main_image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'main_image.max' => 'Размер файла не может превышать 2МБ',
                'artikul.required' => 'Артикул обязательно для заполнения',
                'price.required' => 'Цена обязательно для заполнения',
                'brand_id.required' => 'Выберите бренд',
                'category_id.required' => 'Выберите категорию',
                'filters.required' => 'Выберите фильтры',
//                'size_id.required' => 'Выберите тип размера',
//                'size_items.required' => 'Выберите размер'
            ]
        );
        $requestData = $request->all();

        if ($request->hasFile('main_image')) {
            $name = hexdec(uniqid()) . '.' . $requestData['main_image']->extension();
            $path = 'product';
            $requestData['main_image'] = $request->file('main_image')->storeAs($path, $name, 'static');
        }

        $title = new Translate();
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        $title->save();

        // $short_description = new Translate();
        // $short_description->ru = $requestData['short_description']['ru'];
        // $short_description->en = $requestData['short_description']['en'];
        // $short_description->kz = $requestData['short_description']['kz'];
        // $short_description->save();

        $description = new Translate();
        $description->ru = $requestData['description']['ru'];
        $description->en = $requestData['description']['en'];
        $description->kz = $requestData['description']['kz'];
        $description->save();

//        $specifications = new Translate();
//        $specifications->ru = $requestData['specifications']['ru'];
//        $specifications->en = $requestData['specifications']['en'];
//        $specifications->kz = $requestData['specifications']['kz'];
//        $specifications->save();

        $meta_description = new Translate();
        $meta_description->ru = NULL;
        $meta_description->en = NULL;
        $meta_description->save();

        $meta_title = new Translate();
        $meta_title->ru = NULL;
        $meta_title->en = NULL;
        $meta_title->save();

        $product = new Product();

        $product->title = $title->id;
        //$product->short_description = $short_description->id;
        $product->description = $description->id;
//        $product->specifications = $specifications->id;
        $product->artikul = $requestData['artikul'];
        $product->stock = $requestData['stock'];
        $product->price = $requestData['price'];
        $product->main_image = $requestData['main_image'];
        $product->sale = $requestData['sale'];
        if ($requestData['sale'] != NULL) {
            $product->current_price = (intval($requestData['price']) * (100 - intval($requestData['sale']))) / 100;
        } else {
            $product->current_price = $requestData['price'];
        }

        $product->brand_id = $requestData['brand_id'];
        $product->country_id = $requestData['country_id'];
        $product->category_id = $requestData['category_id'];
//        $product->size_id = $requestData['size_id'];
        $product->slug = Str::slug($requestData['title']['ru'] . '-' . $requestData['artikul']);
        if ($product->save()) {
            if ($request->hasFile('images')) {
                foreach ($requestData['images'] as $item) {
                    // dd($item->getFilename());
                    $name = hexdec(uniqid()) . '.' . $item->extension();
                    $path = 'product/' . $product->slug;
                    $item = $item->storeAs($path, $name, 'static');

                    $product_image = new ProductImages();
                    $product_image->product_id = $product->id;
                    $product_image->image = $item;
                    $product_image->save();
                }
            }

            if ($request->input('size_items')) {
                foreach ($requestData['size_items'] as $item) {
                    $size = new ProductSizeRelations();
                    $size->product_id = $product->id;
                    $size->size_item_id = $item;
                    $size->save();
                }
            }

            if ($request->input('filters')) {
                foreach ($requestData['filters'] as $item) {
                    $filters = new ProductFilterRelations();
                    $filters->product_id = $product->id;
                    $filters->filter_item_id = $item;
                    $filters->save();
                }
            }

            if ($request->input('colors')) {
                foreach ($requestData['colors'] as $item) {
                    $colors = new ColorRelations();
                    $colors->product_id = $product->id;
                    $colors->color_id = $item;
                    $colors->save();
                }
            }
        }
        if (!ProductFeature::where('product_id', $product->id)->exists()) {
            $type = Translate::create([
                'ru' => $request['feature_type']['ru'],
                'kz' => $request['feature_type']['kz'],
                'en' => $request['feature_type']['en'],
            ]);
            $purpose = Translate::create([
                'ru' => $request['feature_purpose']['ru'],
                'kz' => $request['feature_purpose']['kz'],
                'en' => $request['feature_purpose']['en'],
            ]);
            $size = Translate::create([
                'ru' => $request['feature_size']['ru'],
                'kz' => $request['feature_size']['kz'],
                'en' => $request['feature_size']['en'],
            ]);
            $quantity = Translate::create([
                'ru' => $request['feature_quantity']['ru'],
                'kz' => $request['feature_quantity']['kz'],
                'en' => $request['feature_quantity']['en'],
            ]);
            ProductFeature::insert([
                'product_id' => $product->id,
                'type' => $type->id,
                'purpose' => $purpose->id,
                'size' => $size->id,
                'quantity' => $quantity->id,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect('admin/product')->with('flash_message', 'Товар добавлен');
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
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
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
        $product = Product::findOrFail($id);

        $category = Category::join('translates', 'translates.id', 'categories.title')->whereNull('categories.parent_id')->select('categories.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $brands = Brand::join('translates', 'translates.id', 'brands.title')->select('brands.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $colors = Color::join('translates', 'translates.id', 'colors.title')->select('colors.id as id', 'translates.ru as title', 'colors.code')->orderBy('translates.ru')->get();
        $country = Country::join('translates', 'translates.id', 'countries.title')->select('countries.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $size = Size::join('translates', 'translates.id', 'sizes.title')->select('sizes.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $images = ProductImages::where('product_id', $id)->get();
        $colors_rel = ColorRelations::where('product_id', $id)->get();
        $colors_arr[] = null;
        foreach ($colors_rel as $item) {
            $colors_arr[] = $item->color_id;
        }

        $filters = CategoryFilterRelations::where('category_id', $product->category_id)->get();
        $prod_filters = ProductFilterRelations::where('product_id', $id)->get();
        $filters_arr[] = null;
        foreach ($prod_filters as $item) {
            $filters_arr[] = $item->filter_item_id;
        }
        $size_items = SizeItems::join('translates', 'translates.id', 'size_items.title')->where('size_id', $product->size_id)->select('size_items.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $prod_size = ProductSizeRelations::where('product_id', $id)->get();
        $size_arr[] = null;
        foreach ($prod_size as $item) {
            $size_arr[] = $item->size_item_id;
        }
        $brand_items = BrandItems::join('translates', 'translates.id', 'brand_items.title')->where('brand_items.brand_id', $product->brand_id)->select('brand_items.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();

        $feature = ProductFeature::where('product_id', $id)->first();

        return view('products.edit', compact(
            'product',
            'category',
            'brands',
            'colors',
            'country',
            'colors_arr',
            'filters_arr',
            'filters',
            'images',
            'size',
            'size_arr',
            'size_items',
            'brand_items',
            'feature',
        ));
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
        $request->validate(
            [
                'title.ru' => 'required',
                'artikul' => 'required',
                'price' => 'required',
                //'short_description.ru' => 'required',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'brand_id' => 'required',
                'category_id' => 'required',
                'filters' => 'required',
//                'size_id' => 'required',
//                'size_items' => 'required'
            ],
            [
                'title.ru.required' => 'Заголовок обязательно для заполнения',
                //'short_description.ru.required' => 'краткое описание обязательно для заполнения',
                'images.image' => 'Файл должен быть картинкой',
                'images.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'images.max' => 'Размер файла не может превышать 2МБ',
                'main_image.image' => 'Файл должен быть картинкой',
                'main_image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'main_image.max' => 'Размер файла не может превышать 2МБ',
                'artikul.required' => 'Артикул обязательно для заполнения',
                'price.required' => 'Цена обязательно для заполнения',
                'brand_id.required' => 'Выберите бренд',
                'category_id.required' => 'Выберите категорию',
                'filters.required' => 'Выберите фильтры',
                'size_id.required' => 'Выберите тип размера',
                'size_items.required' => 'Выберите размер'
            ]
        );
        $requestData = $request->all();
        $product = Product::findOrFail($id);

        if ($request->hasFile('main_image')) {
            if ($product->main_image != null) {
                Storage::disk('static')->delete($product->main_image);
            }
            $name = hexdec(uniqid()) . '.' . $requestData['main_image']->extension();
            $path = 'product';
            $requestData['main_image'] = $request->file('main_image')->storeAs($path, $name, 'static');
            $product->main_image = $requestData['main_image'];
        }

        $title = Translate::find($product->title);
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        $title->update();

        // $short_description = Translate::find($product->short_description);;
        // $short_description->ru = $requestData['short_description']['ru'];
        // $short_description->en = $requestData['short_description']['en'];
        // $short_description->kz = $requestData['short_description']['kz'];
        // $short_description->update();

        $description = Translate::find($product->description);
        $description->ru = $requestData['description']['ru'];
        $description->en = $requestData['description']['en'];
        $description->kz = $requestData['description']['kz'];
        $description->update();

//        $specifications = Translate::find($product->specifications);
//        $specifications->ru = $requestData['specifications']['ru'];
//        $specifications->en = $requestData['specifications']['en'];
//        $specifications->kz = $requestData['specifications']['kz'];
//        $specifications->update();

        $product->artikul = $requestData['artikul'];
        $product->stock = $requestData['stock'];
        $product->price = $requestData['price'];
        $product->sale = $requestData['sale'];

        if ($requestData['sale'] != NULL) {
            $product->current_price = (intval($requestData['price']) * (100 - intval($requestData['sale']))) / 100;
        } else {
            $product->current_price = $requestData['price'];
        }

        $product->brand_id = $requestData['brand_id'];
        $product->brand_items_id = $requestData['brand_items'];
        $product->country_id = $requestData['country_id'];
        $product->category_id = $requestData['category_id'];
//        $product->size_id = $requestData['size_id'];
        $product->slug = Str::slug($requestData['title']['ru'] . '-' . $requestData['artikul']);
        if ($product->update()) {
            if ($request->hasFile('images')) {
                foreach ($requestData['images'] as $item) {
                    $name = hexdec(uniqid()) . '.' . $item->extension();
                    $path = 'product/' . $product->slug;
                    $item = $item->storeAs($path, $name, 'static');

                    $product_image = new ProductImages();
                    $product_image->product_id = $product->id;
                    $product_image->image = $item;
                    $product_image->save();
                }
            }

            if ($request->input('filters')) {
                $filters = ProductFilterRelations::where('product_id', $id)->get();
                if ($filters) {
                    foreach ($filters as $item) {
                        $item->delete();
                    }
                }
                foreach ($requestData['filters'] as $item) {
                    $filters = new ProductFilterRelations();
                    $filters->product_id = $product->id;
                    $filters->filter_item_id = $item;
                    $filters->save();
                }
            }

            $size = ProductSizeRelations::where('product_id', $id)->get();
            if ($size) {
                foreach ($size as $item) {
                    $item->delete();
                }
            }
            if ($request->input('size_items')) {
                foreach ($requestData['size_items'] as $item) {
                    $size = new ProductSizeRelations();
                    $size->product_id = $product->id;
                    $size->size_item_id = $item;
                    $size->save();
                }
            }

            $colors = ColorRelations::where('product_id', $id)->get();
            if ($colors) {
                foreach ($colors as $item) {
                    $item->delete();
                }
            }

            if ($request->input('colors')) {
                foreach ($requestData['colors'] as $item) {
                    $colors = new ColorRelations();
                    $colors->product_id = $product->id;
                    $colors->color_id = $item;
                    $colors->save();
                }
            }

            if (array_key_exists('q_colors', $requestData) && array_key_exists('q_sizes', $requestData)) {
                $jj = 0;
                Quantity::where('product_id', $product->id)->delete();
                foreach ($requestData['q_colors'] as $color) {
                    $size = $requestData['q_sizes'][$jj];
                    if (isset($requestData['quantity'][$jj])) {
                        $q = $requestData['quantity'][$jj];
                    } else {
                        $q = 0;
                    }
                    Quantity::create([
                        'product_id' => $product->id,
                        'color_id' => $color,
                        'size_id' => $size,
                        'quantity' => $q,
                    ]);
                    $jj++;
                }

                $uniqueQSizes = array_unique($requestData['q_sizes']);
                if (array_key_exists('size_items', $requestData)) {
                    $sizeDif = array_diff($uniqueQSizes, $requestData['size_items']);
                } else {
                    $sizeDif = $uniqueQSizes;
                }

                Quantity::where('product_id', $product->id)->whereIn('size_id', $sizeDif)->delete();


                $uniqueQColors = array_unique($requestData['q_colors']);
                if (array_key_exists('colors', $requestData)) {
                    $colorDif = array_diff($uniqueQColors, $requestData['colors']);
                } else {
                    $colorDif = $uniqueQColors;
                }
                Quantity::where('product_id', $product->id)->whereIn('color_id', $colorDif)->delete();
            }
        }

        $feature = ProductFeature::where('product_id', $id)->first();
        if ($feature) {
            Translate::find($feature->type)->update([
                'ru' => $request['feature_type']['ru'],
                'kz' => $request['feature_type']['kz'],
                'en' => $request['feature_type']['en'],
            ]);
            Translate::find($feature->purpose)->update([
                'ru' => $request['feature_purpose']['ru'],
                'kz' => $request['feature_purpose']['kz'],
                'en' => $request['feature_purpose']['en'],
            ]);
            Translate::find($feature->size)->update([
                'ru' => $request['feature_size']['ru'],
                'kz' => $request['feature_size']['kz'],
                'en' => $request['feature_size']['en'],
            ]);
            Translate::find($feature->quantity)->update([
                'ru' => $request['feature_quantity']['ru'],
                'kz' => $request['feature_quantity']['kz'],
                'en' => $request['feature_quantity']['en'],
            ]);
        } else {
            $type = Translate::create([
                'ru' => $request['feature_type']['ru'],
                'kz' => $request['feature_type']['kz'],
                'en' => $request['feature_type']['en'],
            ]);
            $purpose = Translate::create([
                'ru' => $request['feature_purpose']['ru'],
                'kz' => $request['feature_purpose']['kz'],
                'en' => $request['feature_purpose']['en'],
            ]);
            $size = Translate::create([
                'ru' => $request['feature_size']['ru'],
                'kz' => $request['feature_size']['kz'],
                'en' => $request['feature_size']['en'],
            ]);
            $quantity = Translate::create([
                'ru' => $request['feature_quantity']['ru'],
                'kz' => $request['feature_quantity']['kz'],
                'en' => $request['feature_quantity']['en'],
            ]);
            ProductFeature::insert([
                'product_id' => $id,
                'type' => $type->id,
                'purpose' => $purpose->id,
                'size' => $size->id,
                'quantity' => $quantity->id,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('product.edit', $product->id)->with('flash_message', 'Товар обновлен');
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
        $product = Product::find($id);
        $check_order = OrderProducts::where('product_id', $id)->first();
        if ($check_order) {
            OrderProducts::where('product_id', $id)->delete();
//            return redirect('admin/product')->with('error', 'Товар нельзя удалить');
        }
        $product_images = ProductImages::where('product_id', $id)->get();
        if ($product_images != null) {
            foreach ($product_images as $item) {
                Storage::disk('static')->delete($item->image);
            }
        }

        if ($product->main_image != null) {
            Storage::disk('static')->delete($product->main_image);
        }

        $title = Translate::find($product->title);
        if ($title) {
            $title->delete();
        }

        // $short_description = Translate::find($product->short_description);
        // if ($short_description) {
        //     $short_description->delete();
        // }

        $description = Translate::find($product->description);
        if ($description) {
            $description->delete();
        }

        $specifications = Translate::find($product->specifications);
        if ($specifications) {
            $specifications->delete();
        }

        if ($product->meta_title != null) {
            $meta_title = Translate::find($product->meta_title);
            $meta_title->delete();
        }
        if ($product->meta_description != null) {
            $meta_description = Translate::find($product->meta_description);
            $meta_description->delete();
        }

        $filters = ProductFilterRelations::where('product_id', $id)->get();

        if ($filters) {
            foreach ($filters as $item) {
                $item->delete();
            }
        }

        $colors = ColorRelations::where('product_id', $id)->get();
        if ($colors) {
            foreach ($colors as $item) {
                $item->delete();
            }
        }
        if (ProductFeature::where('product_id', $product->id)->exists()) {
            ProductFeature::where('product_id', $product->id)->delete();
        }

        $product->delete();

        return redirect('admin/product')->with('flash_message', 'Товар удален');
    }

    public function imgDelete($id)
    {
        $img = ProductImages::find($id);
        $img->delete();
        if ($img->image != null) {
            Storage::disk('static')->delete($img->image);
        }

        return true;
    }

    public function editSeo($id)
    {
        $product = Product::find($id);

        return view('products.meta_seo', compact('product'));
    }

    public function updateSeo(Request $request, $id)
    {
        $requestData = $request->all();
        $product = Product::find($id);

        $meta_title = Translate::where('id', $product->meta_title)->first();
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
            $product->meta_title = $create_title->id;
            $product->update();
        }

        $meta_description = Translate::where('id', $product->meta_description)->first();
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
            $product->meta_description = $create_description->id;
            $product->update();
        }

        return redirect()->with('flash_message', 'Мета данные сохранены');
    }

    public function import()
    {
        return view('products.import');
    }

    public function importZip()
    {
        return view('products.import-zip');
    }

    public function admission($id)
    {
        $product = Product::findOrFail($id);
        $admission = Admission::where('product_id', $id)->get();

        return view('products.admission', compact('admission', 'product'));
    }

    public function admissionStore(Request $request, $id)
    {
        $requestData = $request->all();

        $admission = new Admission();
        $admission->product_id = $id;
        $admission->phone_number = $requestData['phone_number'];

        if ($admission->save()) {
            return redirect('admin/admission/' . $id)->with('flash_message', 'Значение добавлено');
        } else {
            return redirect('admin/admission/' . $id)->with('error', 'Возникла ошибка при добавлении');
        }
    }

    // public function admissionUpdate(Request $request, $id)
    // {
    //     $requestData = $request->all();

    //     $admission = Admission::find($id);
    //     $title = Translate::find($city->title);
    //     $title->ru = $requestData['title']['ru'];
    //     $title->kz = $requestData['title']['kz'];
    //     $title->en = $requestData['title']['en'];
    //     $title->update();


    //     if($title->update()){
    //         return redirect('admin/admission/'.$requestData['region_id'])->with('flash_message', 'Значение добавлено');
    //     }else{
    //         return redirect('admin/admission/'.$requestData['region_id'])->with('error', 'Возникла ошибка при добавлении');
    //     }
    // }

    public function admissionDelete($id)
    {
        $admission = Admission::find($id);

        $product_id = $admission->product_id;
        if ($admission->delete()) {
            return redirect('admin/admission/' . $product_id)->with('flash_message', 'Значение удалено');
        } else {
            return redirect('admin/admission/' . $product_id)->with('error', 'Возникла ошибка при удалении');
        }
    }

    public function updatePosition(Request $request, $id)
    {
        $requestData = $request->all();
        $product = Product::findOrFail($id);
        $product->menu_position = $requestData['position'];
        $product->update();

        return $id;
    }

    public function priceTypes($id)
    {
        $prices = ProductPriceTypes::where('product_id', $id)->get();
        $product = Product::find($id);

        return view('products.price-type', compact('prices', 'product'));
    }

    public function createPriceType($id)
    {
        $product = Product::find($id);
        $types = PriceType::get();
        $productPriceTypes = ProductPriceTypes::where('product_id', $id)->pluck('price_type_id')->toArray();

        return view('products.add-price-type', compact('product', 'types', 'productPriceTypes'));
    }

    public function storePriceType(Request $request)
    {
        ProductPriceTypes::insert([
            'price_type_id' => $request['price_type_id'],
            'product_id' => $request['product'],
            'price' => $request['price'],
        ]);

        return redirect()->route('product-price-types', $request['product'])->with('success', 'Успешно добавлено');
    }

    public function destroyPriceType($id)
    {
        $priceType = ProductPriceTypes::find($id);
        $product = $priceType->product_id;
        $priceType->delete();

        return redirect()->route('product-price-types', $product)->with('success', 'Успешно удалено');
    }

    public function updateImport()
    {
        return view('products.update-import');
    }

    public function updateImportExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx|max:20480',
        ], [
            'file.max' => 'Размер файла не может быть более 20 Мегабайтов.',
            'file.required' => 'Выберите файл.',
            'file.mimes' => 'Выберите файл excel'
        ]);
        $array = Excel::toArray(new ProductImport, request()->file('file'));
        $i = 0;
        $errors = 0;
        $articul = '';
        foreach ($array[0] as $item) {
            set_time_limit(30);
            $product = Product::where('artikul', $item['artikul'])->first();
            if ($product) {
                $product->price = $item['osnovnaya_cena'];
                $product->stock = $item['nalicie'];
                $product->save();
                $feature = ProductFeature::where('product_id', $product->id)->first();
                Translate::find($feature->quantity)->update([
                    'ru' => $item['kolicestvo'],
                    'kz' => $item['kolicestvo'],
                    'en' => $item['kolicestvo'],
                ]);
                if (ProductPriceTypes::where('product_id', $product->id)->where('price_type_id', $item['cena_1_id'])->exists()) {
                    ProductPriceTypes::where('product_id', $product->id)->where('price_type_id', $item['cena_1_id'])->update([
                        'product_id' => $product->id,
                        'price_type_id' => $item['cena_1_id'],
                        'price' => $item['cena_1']
                    ]);
                } else {
                    ProductPriceTypes::insert([
                        'product_id' => $product->id,
                        'price_type_id' => $item['cena_1_id'],
                        'price' => $item['cena_1']
                    ]);
                }
                if (ProductPriceTypes::where('product_id', $product->id)->where('price_type_id', $item['cena_2_id'])->exists()) {
                    ProductPriceTypes::where('product_id', $product->id)->where('price_type_id', $item['cena_2_id'])->update([
                        'product_id' => $product->id,
                        'price_type_id' => $item['cena_2_id'],
                        'price' => $item['cena_2']
                    ]);
                } else {
                    ProductPriceTypes::insert([
                        'product_id' => $product->id,
                        'price_type_id' => $item['cena_2_id'],
                        'price' => $item['cena_2']
                    ]);
                }
                if (ProductPriceTypes::where('product_id', $product->id)->where('price_type_id', $item['cena_3_id'])->exists()) {
                    ProductPriceTypes::where('product_id', $product->id)->where('price_type_id', $item['cena_3_id'])->update([
                        'product_id' => $product->id,
                        'price_type_id' => $item['cena_3_id'],
                        'price' => $item['cena_3']
                    ]);
                } else {
                    ProductPriceTypes::insert([
                        'product_id' => $product->id,
                        'price_type_id' => $item['cena_3_id'],
                        'price' => $item['cena_3']
                    ]);
                }
                if (ProductPriceTypes::where('product_id', $product->id)->where('price_type_id', $item['cena_4_id'])->exists()) {
                    ProductPriceTypes::where('product_id', $product->id)->where('price_type_id', $item['cena_4_id'])->update([
                        'product_id' => $product->id,
                        'price_type_id' => $item['cena_4_id'],
                        'price' => $item['cena_4']
                    ]);
                } else {
                    ProductPriceTypes::insert([
                        'product_id' => $product->id,
                        'price_type_id' => $item['cena_4_id'],
                        'price' => $item['cena_4']
                    ]);
                }
                if (ProductPriceTypes::where('product_id', $product->id)->where('price_type_id', $item['cena_5_id'])->exists()) {
                    ProductPriceTypes::where('product_id', $product->id)->where('price_type_id', $item['cena_5_id'])->update([
                        'product_id' => $product->id,
                        'price_type_id' => $item['cena_5_id'],
                        'price' => $item['cena_5']
                    ]);
                } else {
                    ProductPriceTypes::insert([
                        'product_id' => $product->id,
                        'price_type_id' => $item['cena_5_id'],
                        'price' => $item['cena_5']
                    ]);
                }
            }
        }

        return redirect('/admin/product')->with('success', 'Файлы успешно импортирован!');
    }
}
