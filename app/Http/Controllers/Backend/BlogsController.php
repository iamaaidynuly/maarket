<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Translate;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogsController extends Controller
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
            $blogs = Blog::where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->orWhere('image', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $blogs = Blog::latest()->paginate($perPage);
        }

        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('blogs.create');
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],
        [
            'title.ru.required' => 'Заголовок обязательно для заполнения',
            'image.image' => 'Файл должен быть картинкой',
            'image.required' => 'Загрузите изображение',
            'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)'
        ]);

        $requestData = $request->all();

        if ($request->hasFile('image')) {

            $name = time().'.'.$requestData['image']->extension();
            $path = 'blogs';
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
        
        $blog = new Blog();
        $blog->title = $title->id;
        $blog->content = $content->id;
        $blog->image = $requestData['image'];
        $blog->slug = Str::slug($requestData['title']['ru']);
        $blog->save();

        return redirect('admin/blogs')->with('flash_message', 'Блог добавлен');
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
        $blog = Blog::findOrFail($id);

        return view('blogs.show', compact('blog'));
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
        $blog = Blog::findOrFail($id);

        return view('blogs.edit', compact('blog'));
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
            'title.ru' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],
        [
            'title.ru.required' => 'Заголовок обязательно для заполнения',
            'image.image' => 'Файл должен быть картинкой',
            'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)'
        ]);

        $requestData = $request->all();

        $blog = Blog::findOrFail($id);

        if ($request->hasFile('image')) {
            if($blog->image != null){
                Storage::disk('static')->delete($blog->image);
            }
            $name = time().'.'.$requestData['image']->extension();
            $path = 'blogs';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');

            $blog->image = $requestData['image'];
        }
            $title = Translate::find($blog->title);
            $title->ru = $requestData['title']['ru'];
            $title->en = $requestData['title']['en'];
            $title->update();
            $content = Translate::find($blog->content);
            $content->ru = $requestData['content']['ru'];
            $content->en = $requestData['content']['en'];
            $content->update();
        
        $blog->update();

        return redirect('admin/blogs')->with('flash_message', 'Блог сохранен');
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
        $blog = Blog::findOrFail($id);
        
        if($blog->image != null){
            Storage::disk('static')->delete($blog->image);
        }

        $title = Translate::find($blog->title);
        $title->delete();

        $content = Translate::find($blog->content);
        $content->delete();

        $blog->delete();

        return redirect('admin/blogs')->with('flash_message', 'Блог удален');
    }

    public function editSeo($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blogs.meta_seo', compact('blog'));
    }
    public function updateSeo(Request $request, $id)
    {
        $requestData = $request->all();
        $blog = Blog::findOrFail($id);

        $meta_title = Translate::where('id', $blog->meta_title)->first();
        if($meta_title){
            $meta_title->ru = $requestData['meta_title']['ru'];
            $meta_title->en = $requestData['meta_title']['en'];
            $meta_title->update();
        }else{
            $create_title = new Translate();
            $create_title->ru = $requestData['meta_title']['ru'];
            $create_title->en = $requestData['meta_title']['en'];
            $create_title->save();
            $blog->meta_title = $create_title->id;
            $blog->update();
        }

        $meta_description = Translate::where('id', $blog->meta_description)->first();
        if($meta_description){
            $meta_description->ru = $requestData['meta_description']['ru'];
            $meta_description->en = $requestData['meta_description']['en'];
            $meta_description->update();
        }else{
            $create_description = new Translate();
            $create_description->ru = $requestData['meta_description']['ru'];
            $create_description->en = $requestData['meta_description']['en'];
            $create_description->save();
            $blog->meta_description = $create_description->id;
            $blog->update();
        }

        return redirect('admin/blogs')->with('flash_message', 'Мета данные сохранены');
    }
}
