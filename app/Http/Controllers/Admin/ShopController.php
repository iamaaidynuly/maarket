<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Shop;
use App\Service\ShopService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $shops;

    public function __construct(Shop $shops)
    {
        $this->shops = $shops;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $shops = $this->shops->paginate(15);

        return view('admin.shop.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::get();

        return view('admin.shop.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        (new ShopService())->create($request->all());

        return redirect()->route('shops.index')->with('success', 'Успешно добавлено!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop = $this->shops->find($id);

        return view('admin.shop.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities = City::get();
        $shop = $this->shops->find($id);

        return view('admin.shop.edit', compact('cities', 'shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Shop $shop)
    {
        (new ShopService())->update($shop, $request->all());

        return redirect()->route('shops.index')->with('success', 'Успешно обновлено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->shops->find($id)->delete();

        return redirect()->route('shops.index')->with('success', 'Успешно удалено!');
    }
}
