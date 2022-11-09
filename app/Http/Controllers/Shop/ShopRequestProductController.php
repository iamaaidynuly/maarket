<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Country;
use App\Models\ProductFilterRelations;
use App\Models\ProductImages;
use App\Models\ShopRequestImage;
use App\Models\ShopRequestProduct;
use App\Models\ShopRequestProductFilterRelation;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Service\TranslateService;
use Illuminate\Support\Str;

class ShopRequestProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $magazin = $request->session()->get('magazin');
        $requestProducts = ShopRequestProduct::where('shop_id', $magazin->id)->orderBy('created_at', 'desc')->paginate(15);

        return view('shop.request-product.index', [
            'requestProducts' => $requestProducts,
            'magazin' => $magazin,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $category = Category::join('translates', 'translates.id', 'categories.title')->whereNull('categories.parent_id')->select('categories.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $brands = Brand::join('translates', 'translates.id', 'brands.title')->select('brands.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $colors = Color::join('translates', 'translates.id', 'colors.title')->select('colors.id as id', 'translates.ru as title', 'colors.code')->orderBy('translates.ru')->get();
        $country = Country::join('translates', 'translates.id', 'countries.title')->select('countries.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();
        $colors_arr[] = null;
        $filters_arr[] = null;
        $size_arr[] = null;
        $magazin = $request->session()->get('magazin');

        return view('shop.request-product.create', compact('magazin', 'category', 'brands', 'colors', 'country', 'filters_arr', 'colors_arr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $title = (new \App\Service\TranslateService)->translateCreate($request['title']);
        $description = (new \App\Service\TranslateService)->translateCreate($request['description']);
        if ($request->hasFile('main_image')) {
            $name = hexdec(uniqid()) . '.' . $request['main_image']->extension();
            $path = 'product';
            $mainImage = $request->file('main_image')->storeAs($path, $name, 'static');
        }
        $shopRequest = ShopRequestProduct::create([
            'shop_id' => $request['shop_id'],
            'title' => $title->id,
            'description' => $description->id,
            'artikul' => $request['artikul'],
            'stock' => $request['stock'],
            'price' => $request['price'],
            'sale' => $request['sale'] ?? 0,
            'current_price' => (intval($request['price']) * (100 - intval($request['sale']))) / 100,
            'brand_id' => $request['brand_id'],
            'brand_items_id' => $request['brand_items'],
            'category_id' => $request['category_id'],
            'country_id' => $request['country_id'],
            'slug' => Str::slug($request['title']['ru'] . '-' . $request['artikul']),
            'main_image' => $mainImage ?? null,
            'created_at' => Carbon::now(),
        ]);
        if ($request->hasFile('images')) {
            foreach ($request['images'] as $item) {
                // dd($item->getFilename());
                $name = hexdec(uniqid()) . '.' . $item->extension();
                $path = 'product/' . $shopRequest->slug;
                $item = $item->storeAs($path, $name, 'static');

                $product_image = new ShopRequestImage();
                $product_image->shop_request_product_id = $shopRequest->id;
                $product_image->image = $item;
                $product_image->save();
            }
        }
        if ($request->input('filters')) {
            foreach ($request['filters'] as $item) {
                $filters = new ShopRequestProductFilterRelation();
                $filters->shop_request_product_id = $shopRequest->id;
                $filters->filter_item_id = $item;
                $filters->save();
            }
        }

        return redirect()->route('shop_request_products.index')->with('success', 'Успешно добавлено');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(ShopRequestProduct $shopRequestProduct)
    {
        $images = ShopRequestImage::where('shop_request_product_id', $shopRequestProduct->id)->pluck('image')->toArray();
        $shopRequestProduct['images'] = $images;
        $magazin = session()->get('magazin');

        return view('shop.request-product.show', compact('shopRequestProduct', 'magazin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $requestProduct = ShopRequestProduct::findOrFail($id);
        ShopRequestProductFilterRelation::where('shop_request_product_id', $id)->delete();
        ShopRequestImage::where('shop_request_product_id', $id)->delete();

        $requestProduct->delete();

        return redirect()->route('shop_request_products.index')->with('success', 'Успешно удалено');
    }
}
