<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopProductResource;
use App\Models\Brand;
use App\Models\BrandItems;
use App\Models\Category;
use App\Models\CategoryFilterRelations;
use App\Models\Color;
use App\Models\ColorRelations;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductFilterRelations;
use App\Models\ProductImages;
use App\Models\ProductSizeRelations;
use App\Models\Quantity;
use App\Models\ShopProduct;
use App\Models\Size;
use App\Models\SizeItems;
use App\Models\Translate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shop = $request->session()->get('magazin');
        $shopProducts = ShopProduct::whereShopId($shop->id)->paginate(15);

        return view('shop.product.index', [
            'magazin'   =>  $shop,
            'shopProducts'  =>  $shopProducts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
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
        $magazin = session()->get('magazin');

        return view('shop.product.create', compact('category', 'brands', 'colors', 'country', 'colors_arr', 'filters_arr', 'size', 'size_arr', 'magazin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = ShopProduct::findOrFail($id);
        $product = Product::findOrFail($shop->product_id);
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
        $magazin = session()->get('magazin');

        return view('shop.product.edit', compact(
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
            'magazin',
            'shop',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
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

        return redirect()->route('products.edit', $product->id)->with('flash_message', 'Товар обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
