<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

use App\Models\Instum;
use Illuminate\Http\Request;

class InstaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $perPage = 25;
        $insta = Instum::latest()->paginate($perPage);
        

        return view('insta.index', compact('insta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('insta.create');
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
        [
            'image.image' => 'Файл должен быть картинкой',
            'image.required' => 'Загрузите изображение',
            'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
            'image.max' => 'Размер файла не может превышать 2МБ'
        ]);

        $requestData = $request->all();

        if ($request->hasFile('image')) {

            $name = time().'.'.$requestData['image']->extension();
            $path = 'insta';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');
        }

        $insta = new Instum();
        $insta->image = $requestData['image'];
        $insta->link = $requestData['link'];
        $insta->save();

        return redirect('admin/insta')->with('flash_message', 'Добавлен!');
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
        $instum = Instum::findOrFail($id);

        return view('insta.show', compact('instum'));
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
        $instum = Instum::findOrFail($id);

        return view('insta.edit', compact('instum'));
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
        [
            'image.image' => 'Файл должен быть картинкой',
            'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
            'image.max' => 'Размер файла не может превышать 2МБ'
        ]);

        
        $requestData = $request->all();
        $instum = Instum::findOrFail($id);

        if ($request->hasFile('image')) {
            if($instum->image != null){
                Storage::disk('static')->delete($instum->image);
            }
            $name = time().'.'.$requestData['image']->extension();
            $path = 'insta';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');

            $instum->image = $requestData['image'];
            $instum->link = $requestData['link'];
        }

        $instum->update($requestData);

        return redirect('admin/insta')->with('flash_message', 'Сохранен!');
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
        $instum = Instum::findOrFail($id);

        if($instum->image != null){
            Storage::disk('static')->delete($instum->image);
        }

        $instum->delete();

        return redirect('admin/insta')->with('flash_message', 'Удален!');
    }
}
