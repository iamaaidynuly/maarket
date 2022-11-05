<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Translate;

use App\Models\SalesBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SalesBlockController extends Controller
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

        if (!empty($keyword)) {
            $salesblock = SalesBlock::where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->orWhere('image', 'LIKE', "%$keyword%")
                ->orWhere('url', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $salesblock = SalesBlock::latest()->paginate($perPage);
        }

        return view('sales-block.index', compact('salesblock'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('sales-block.create');
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
            'content.ru' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],
        [
            'title.ru.required' => 'Заголовок обязательно для заполнения',
            'content.ru.required' => 'Описание обязательно для заполнения',
            'image.image' => 'Файл должен быть картинкой',
            'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)'
        ]);

        $requestData = $request->all();
        
        if ($request->hasFile('image')) {

            $name = time().'.'.$requestData['image']->extension();
            $path = 'sales';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');
        }
        $title = new Translate();
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->save();
        $content = new Translate();
        $content->ru = $requestData['content']['ru'];
        $content->en = $requestData['content']['en'];
        $content->save();
        $url = new Translate();
        $url->ru = $requestData['url']['ru'];
        $url->en = $requestData['url']['en'];
        $url->save();

        $block = new SalesBlock();
        $block->title = $title->id;
        $block->content = $content->id;
        $block->url = $url->id;
        $block->image = $requestData['image'];
        $block->save();

        return redirect('admin/sales-block')->with('flash_message', 'Блок добавлен');
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
        $salesblock = SalesBlock::findOrFail($id);

        return view('sales-block.show', compact('salesblock'));
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
        $salesblock = SalesBlock::findOrFail($id);

        return view('sales-block.edit', compact('salesblock'));
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
        
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],
        [
            'image.image' => 'Файл должен быть картинкой',
            'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)'
        ]);
        $requestData = $request->all();

        $block = SalesBlock::findOrFail($id);

        if ($request->hasFile('image')) {
            if($block->image != null){
                Storage::disk('static')->delete($block->image);
            }
            $name = time().'.'.$requestData['image']->extension();
            $path = 'sales';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');

            $block->image = $requestData['image'];
        }
        $title = Translate::find($block->title);
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->update();

        $content = Translate::find($block->content);
        $content->ru = $requestData['content']['ru'];
        $content->en = $requestData['content']['en'];
        $content->update();

        $url = Translate::find($block->url);
        $url->ru = $requestData['url']['ru'];
        $url->en = $requestData['url']['en'];
        $url->update();

        $block->update();

        return redirect('admin/sales-block')->with('flash_message', 'Блок изменен');
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
        $block = SalesBlock::findOrFail($id);

        if($block->image != null){
            Storage::disk('static')->delete($block->image);
        }
        
        $title = Translate::find($block->title);
        $title->delete();

        $content = Translate::find($block->content);
        $content->delete();

        $url = Translate::find($block->url);
        $url->delete();

        $block->delete();

        return redirect('admin/sales-block')->with('flash_message', 'Блок удален');
    }
}
