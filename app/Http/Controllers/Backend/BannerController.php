<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\Translate;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
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

            $banner = Banner::latest()->paginate($perPage);

        return view('banner.index', compact('banner'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('banner.create');
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
            'image_mobile' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'image_desktop' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],
        [
            'image_mobile.image' => 'Файл должен быть картинкой',
            'image_mobile.required' => 'Загрузите изображение',
            'image_mobile.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
            'image_desktop.image' => 'Файл должен быть картинкой',
            'image_desktop.required' => 'Загрузите изображение',
            'image_desktop.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)'
        ]);

        $requestData = $request->all();
        if ($request->hasFile('image_mobile')) {

            $name = time().'.'.$requestData['image_mobile']->extension();
            $path = 'banner/image_mobile';
            $requestData['image_mobile'] = $request->file('image_mobile')->storeAs($path, $name, 'static');
        }
        if ($request->hasFile('image_desktop')) {

            $name = time().'.'.$requestData['image_desktop']->extension();
            $path = 'banner/image_desktop';
            $requestData['image_desktop'] = $request->file('image_desktop')->storeAs($path, $name, 'static');
        }

        $title = new Translate();
        $title->ru = $requestData['title']['ru'];
        $title->kz = $requestData['title']['kz'];
        $title->en = $requestData['title']['en'];
        $title->save();
        $description = new Translate();
        $description->ru = $requestData['description']['ru'];
        $description->kz = $requestData['description']['kz'];
        $description->en = $requestData['description']['en'];
        $description->save();

        $banner = new Banner();
        $banner->title = $title->id;
        $banner->description = $description->id;
        $banner->link = $requestData['link'];
        $banner->image_mobile = $requestData['image_mobile'];
        $banner->image_desktop = $requestData['image_desktop'];
        $banner->save();


        return redirect('admin/banner')->with('flash_message', 'banner added!');
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
        $banner = Banner::findOrFail($id);

        return view('banner.show', compact('banner'));
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
        $banner = Banner::findOrFail($id);

        return view('banner.edit', compact('banner'));
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
            'image_mobile' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'image_desktop' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],
        [
            'image_mobile.image' => 'Файл должен быть картинкой',
            'image_mobile.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
            'image_desktop.image' => 'Файл должен быть картинкой',
            'image_desktop.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)'
        ]);
        $requestData = $request->all();

        $banner = Banner::findOrFail($id);

        if ($request->hasFile('image_mobile')) {
            if($banner->image_mobile != null){
                Storage::disk('static')->delete($banner->image_mobile);
            }
            $name = time().'.'.$requestData['image_mobile']->extension();
            $path = 'banner/image_mobile';
            $requestData['image_mobile'] = $request->file('image_mobile')->storeAs($path, $name, 'static');

            $banner->image_mobile = $requestData['image_mobile'];
        }
        if ($request->hasFile('image_desktop')) {
            if($banner->image_desktop != null){
                Storage::disk('static')->delete($banner->image_desktop);
            }
            $name = time().'.'.$requestData['image_desktop']->extension();
            $path = 'banner/image_desktop';
            $requestData['image_desktop'] = $request->file('image_desktop')->storeAs($path, $name, 'static');

            $banner->image_desktop = $requestData['image_desktop'];
        }
            $title = Translate::find($banner->title);
            $title->ru = $requestData['title']['ru'];
            $title->kz = $requestData['title']['kz'];
            $title->en = $requestData['title']['en'];
            $title->update();
            $description = Translate::find($banner->description);
            $description->ru = $requestData['description']['ru'];
            $description->kz = $requestData['description']['kz'];
            $description->en = $requestData['description']['en'];
            $description->save();
            $banner->link = $requestData['link'];
            $banner->update();

        return redirect('admin/banner')->with('flash_message', 'Обновлен!');
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

        $banner = Banner::findOrFail($id);

        if($banner->image_mobile != null){
            Storage::disk('static')->delete($banner->image_mobile);
        }
        if($banner->image_desktop != null){
            Storage::disk('static')->delete($banner->image_desktop);
        }
        
        $title = Translate::find($banner->title);
        $title->delete();

        $content = Translate::find($banner->description);
        $content->delete();

        $banner->delete();

        return redirect('admin/banner')->with('flash_message', 'Удален!');
    }
}
