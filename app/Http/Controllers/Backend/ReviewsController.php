<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Product;

class ReviewsController extends Controller
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
        $reviews = Review::latest()->paginate($perPage);


        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $products = Product::join('translates', 'translates.id', 'products.title')->select('products.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();

        return view('reviews.create', compact('products'));
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
        Review::create($requestData);

        return redirect('admin/reviews')->with('flash_message', 'Добавлен!');
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
        $review = Review::findOrFail($id);

        return view('reviews.show', compact('review'));
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
        $review = Review::findOrFail($id);
        $products = Product::join('translates', 'translates.id', 'products.title')->select('products.id as id', 'translates.ru as title')->orderBy('translates.ru')->get();

        return view('reviews.edit', compact('review', 'products'));
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
        $requestData = $request->all();

        $review = Review::findOrFail($id);
        $review->update($requestData);

        return redirect('admin/reviews')->with('flash_message', 'Сохранен!');
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
        Review::destroy($id);

        return redirect('admin/reviews')->with('flash_message', 'Удален!');
    }
}
