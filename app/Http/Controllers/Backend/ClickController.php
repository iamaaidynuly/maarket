<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Product;

use App\Models\Click;
use Illuminate\Http\Request;

class ClickController extends Controller
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
        $click = Click::latest()->paginate($perPage);

        return view('click.index', compact('click'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('click.create');
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
        
        Click::create($requestData);

        return redirect('click')->with('flash_message', 'Click added!');
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
        $click = Click::findOrFail($id);
        $product = Product::join('translates','translates.id', 'products.title')->where('products.id',$click->product_id)->select('products.id as id', 'translates.ru as title','products.artikul')->first();

        return view('click.show', compact('click','product'));
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
        $click = Click::findOrFail($id);

        return view('click.edit', compact('click'));
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
        
        $click = Click::findOrFail($id);
        $click->update($requestData);

        return redirect('click')->with('flash_message', 'Click updated!');
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
        Click::destroy($id);

        return redirect('click')->with('flash_message', 'Click deleted!');
    }
}
