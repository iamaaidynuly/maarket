<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Translate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
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
        $slider = Slider::latest()->paginate($perPage);

        return view('slider.index', compact('slider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('slider.create');
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
            'image_mobile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
            [
                'image.image' => 'Файл должен быть картинкой',
                'image.required' => 'Загрузите изображение',
                'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'image.max' => 'Размер файла не может превышать 2МБ',
                'image_mobile.image' => 'Файл должен быть картинкой',
                'image_mobile.required' => 'Загрузите изображение',
                'image_mobile.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'image_mobile.max' => 'Размер файла не может превышать 2МБ'
            ]);
        $requestData = $request->all();
        if ($request->hasFile('image')) {
            $name = time() . '.' . $requestData['image']->extension();
            $path = 'slider/image';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');
        }
        if ($request->hasFile('image_mobile')) {
            $name = time() . '.' . $requestData['image_mobile']->extension();
            $path = 'slider/image_mobile';
            $requestData['image_mobile'] = $request->file('image_mobile')->storeAs($path, $name, 'static');
        }

        $slider = new Slider();
        $title = Translate::create([
            'ru' => $request['title']['ru'],
            'kz' => $request['title']['kz'],
            'en' => $request['title']['en'],
        ]);
        $content = Translate::create([
            'ru' => $request['content']['ru'],
            'kz' => $request['content']['kz'],
            'en' => $request['content']['en'],
        ]);
        $slider->image = $requestData['image'];
        $slider->image_mobile = $requestData['image_mobile'];
        $slider->url = $requestData['url'];
        $slider->title = $title->id;
        $slider->content = $content->id;
        $slider->save();

        return redirect('admin/slider')->with('flash_message', 'Добавлен!');
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
        $slider = Slider::findOrFail($id);

        return view('slider.show', compact('slider'));
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
        $slider = Slider::find($id);

        return view('slider.edit', compact('slider'));
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
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_mobile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
            [
                'image.image' => 'Файл должен быть картинкой',
                'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'image.max' => 'Размер файла не может превышать 2МБ',
                'image_mobile.image' => 'Файл должен быть картинкой',
                'image_mobile.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)',
                'image_mobile.max' => 'Размер файла не может превышать 2МБ'
            ]);
        $requestData = $request->all();

        $slider = Slider::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($slider->image != null) {
                Storage::disk('static')->delete($slider->image);
            }
            $name = time() . '.' . $requestData['image']->extension();
            $path = 'slider/image';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');

            $slider->image = $requestData['image'];
        }
        if ($request->hasFile('image_mobile')) {
            if ($slider->image_mobile != null) {
                Storage::disk('static')->delete($slider->image_mobile);
            }
            $name = time() . '.' . $requestData['image_mobile']->extension();
            $path = 'slider/image_mobile';
            $requestData['image_mobile'] = $request->file('image_mobile')->storeAs($path, $name, 'static');

            $slider->image_mobile = $requestData['image_mobile'];
        }
        $slider->url = $requestData['url'];
        if (isset($slider->title)) {
            Translate::find($slider->title)->update([
                'ru' => $request['title']['ru'],
                'kz' => $request['title']['kz'],
                'en' => $request['title']['en'],
            ]);
        } else {
            $title = Translate::create([
                'ru' => $request['title']['ru'],
                'kz' => $request['title']['kz'],
                'en' => $request['title']['en'],
            ]);
            $slider->title = $title->id;
        }
        if (isset($slider->content)) {
            Translate::find($slider->content)->update([
                'ru' => $request['content']['ru'],
                'kz' => $request['content']['kz'],
                'en' => $request['content']['en'],
            ]);
        } else {
            $content = Translate::create([
                'ru' => $request['content']['ru'],
                'kz' => $request['content']['kz'],
                'en' => $request['content']['en'],
            ]);
            $slider->content = $content->id;
        }

        $slider->update();


        return redirect('admin/slider')->with('flash_message', 'Слайдер сохранен');
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
        $slider = Slider::findOrFail($id);

        if ($slider->image != null) {
            Storage::disk('static')->delete($slider->image);
        }
        if ($slider->image_mobile != null) {
            Storage::disk('static')->delete($slider->image_mobile);
        }


        $slider->delete();

        return redirect('admin/slider')->with('flash_message', 'Слайдер удален');
    }
}
