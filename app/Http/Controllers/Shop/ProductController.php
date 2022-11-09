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
use App\Models\Shop;
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
        $shopProducts = ShopProduct::whereShopId($shop->id)->orderBy('created_at', 'desc')->paginate(15);

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
        $magazin = session()->get('magazin');
        $shop = Shop::find($magazin->id);
        $myProducts = $shop->products->pluck('product_id')->toArray();
        $products = Product::whereNotIn('id', $myProducts)->orderBy('created_at','desc')->get();

        return view('shop.product.create', [
            'magazin'   =>  $magazin,
            'products'  =>  $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        ShopProduct::insert([
            'shop_id'   =>  $request['shop_id'],
            'product_id'   => $request['product'],
            'price' =>  $request['price'],
            'available' =>  $request['available'],
            'created_at'=>  Carbon::now(),
        ]);

        return redirect()->route('products.index')->with('success', 'Успешно добавлено');
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
        $shopProduct = ShopProduct::find($id);
        $magazin = session()->get('magazin');
        $shop = Shop::find($magazin->id);
        $shopProducts = $shop->products->pluck('product_id')->toArray();
        if (in_array($shopProduct->product_id, $shopProducts)) {
            $key = array_search($shopProduct->product_id, $shopProducts);
            unset($shopProducts[$key]);
        }
        $products = Product::orderBy('created_at','desc')->get();

        return view('shop.product.edit',[
            'shopProduct'   =>  $shopProduct,
            'magazin'       =>  $magazin,
            'products'  =>  $products,
            'shop'  =>  $shop,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $shopProduct = ShopProduct::find($id);
        $shopProduct->update([
            'product_id'    =>  $request['product'],
            'price'     =>  $request['price'],
            'available' =>  $request['available'],
        ]);

        return redirect()->route('products.index')->with('flash_message', 'Товар обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        ShopProduct::find($id)->delete();

        return redirect()->route('products.index')->with('success', 'Успешно удалено!');
    }
}
