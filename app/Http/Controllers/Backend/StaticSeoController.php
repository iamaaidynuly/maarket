<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Translate;

use App\Models\StaticSeo;
use Illuminate\Http\Request;

class StaticSeoController extends Controller
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
        $keyword = $request->get('search');
        $perPage = 25;

        $staticseo = StaticSeo::orderBy('title')->paginate($perPage);

        return view('static-seo.index', compact('staticseo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('static-seo.create');
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

        $create_title = new Translate();
        $create_title->ru = $requestData['meta_title']['ru'];
        $create_title->en = $requestData['meta_title']['en'];
        $create_title->save();

        $create_description = new Translate();
        $create_description->ru = $requestData['meta_description']['ru'];
        $create_description->en = $requestData['meta_description']['en'];
        $create_description->save();
        
        $staticseo = new StaticSeo();
        $staticseo->title = $requestData['title'];
        $staticseo->meta_title = $create_title->id;
        $staticseo->meta_description = $create_description->id;
        $staticseo->page = $requestData['page'];
        $staticseo->save();

        return redirect('admin/static-seo')->with('flash_message', 'Сохранен');
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
        return redirect('admin/static-seo')->with('error', 'У вас нет доступа к данной странице');
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
        $staticseo = StaticSeo::findOrFail($id);

        return view('static-seo.edit', compact('staticseo'));
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
        $staticseo = StaticSeo::findOrFail($id);

        $meta_title = Translate::where('id', $staticseo->meta_title)->first();
        $meta_title->ru = $requestData['meta_title']['ru'];
        $meta_title->en = $requestData['meta_title']['en'];
        $meta_title->update();

        $meta_description = Translate::where('id', $staticseo->meta_description)->first();
        $meta_description->ru = $requestData['meta_description']['ru'];
        $meta_description->en = $requestData['meta_description']['en'];
        $meta_description->update();
    

        return redirect('admin/static-seo')->with('flash_message', 'Изменен');
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
        return redirect('admin/static-seo')->with('error', 'У вас нет доступа к данной странице');
    }
}
