<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductFilterRelations;
use App\Models\ShopProduct;
use App\Models\ShopRequestImage;
use App\Models\ShopRequestProduct;
use Illuminate\Http\Request;

class ShopRequestProductController extends Controller
{

    protected $shopRequestProducts;

    public function __construct(ShopRequestProduct $shopRequestProducts)
    {
        $this->shopRequestProducts = $shopRequestProducts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $shopRequestProducts = $this->shopRequestProducts->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.request-product.index', compact('shopRequestProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $shopRequestProduct = $this->shopRequestProducts->find($id);
        $images = ShopRequestImage::where('shop_request_product_id', $id)->pluck('image')->toArray();

        return view('admin.request-product.show', compact('shopRequestProduct', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->shopRequestProducts->find($id)->delete();

        return redirect()->route('request-products.index')->with('success', 'Успешно удалено');
    }

    public function accept($id)
    {
        $shopRequestProduct = $this->shopRequestProducts->find($id);
        $filters = $shopRequestProduct->filters->pluck('filter_item_id')->toArray();
        $product = Product::create($shopRequestProduct->getAttributes());
        foreach ($filters as $filter) {
            ProductFilterRelations::insert([
                'product_id'    =>  $product->id,
                'filter_item_id'=>  $filter,
            ]);
        }
        $shopProduct = ShopProduct::create([
            'shop_id'   =>  $shopRequestProduct->shop_id,
            'product_id'    =>  $product->id,
            'available' =>  true,
            'price' =>  $shopRequestProduct->current_price,
        ]);
        $shopRequestProduct->update([
            'status'    =>  ShopRequestProduct::STATUS_ACCEPTED
        ]);

        return redirect()->back()->with('success', 'Успешно принято!');
    }

    public function reject($id)
    {
        $shopRequestProduct = $this->shopRequestProducts->find($id);
        $shopRequestProduct->update([
            'status'    =>  ShopRequestProduct::STATUS_DECLINED
        ]);

        return redirect()->back()->with('success', 'Успешно отклонено!');
    }
}
