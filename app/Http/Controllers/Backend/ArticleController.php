<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Translate;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
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

            $article = Article::latest()->paginate($perPage);

        return view('article.index', compact('article'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('article.create');
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],
        [
            'image.image' => 'Файл должен быть картинкой',
            'image.required' => 'Загрузите изображение',
            'image.mimes' => 'Проверьте формат изображения (jpeg,png,jpg,gif,svg)'
        ]);

        $requestData = $request->all();
        if ($request->hasFile('image')) {

            $name = time().'.'.$requestData['image']->extension();
            $path = 'article';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');
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

        $article = new Article();
        $article->title = $title->id;
        $article->description = $description->id;
        $article->image = $requestData['image'];
        $article->save();


        return redirect('admin/article')->with('flash_message', 'Article added!');
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
        $article = Article::findOrFail($id);

        return view('article.show', compact('article'));
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
        $article = Article::findOrFail($id);

        return view('article.edit', compact('article'));
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

        $article = Article::findOrFail($id);

        if ($request->hasFile('image')) {
            if($article->image != null){
                Storage::disk('static')->delete($article->image);
            }
            $name = time().'.'.$requestData['image']->extension();
            $path = 'article';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');

            $article->image = $requestData['image'];
        }
            $title = Translate::find($article->title);
            $title->ru = $requestData['title']['ru'];
            $title->kz = $requestData['title']['kz'];
            $title->en = $requestData['title']['en'];
            $title->update();
            $description = Translate::find($article->description);
            $description->ru = $requestData['description']['ru'];
            $description->kz = $requestData['description']['kz'];
            $description->en = $requestData['description']['en'];
            $description->save();
            $article->update();

        return redirect('admin/article')->with('flash_message', 'Обновлен!');
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

        $article = Article::findOrFail($id);

        if($article->image != null){
            Storage::disk('static')->delete($article->image);
        }
        
        $title = Translate::find($article->title);
        $title->delete();

        $content = Translate::find($article->description);
        $content->delete();

        $article->delete();

        return redirect('admin/article')->with('flash_message', 'Удален!');
    }
    public function editSeo($id)
    {
        $article = Article::findOrFail($id);
        return view('article.meta_seo', compact('article'));
    }
    public function updateSeo(Request $request, $id)
    {
        $requestData = $request->all();
        $article = Article::findOrFail($id);

        $meta_title = Translate::where('id', $article->meta_title)->first();
        if($meta_title){
            $meta_title->ru = $requestData['meta_title']['ru'];
            $meta_title->en = $requestData['meta_title']['en'];
            $meta_title->kz = $requestData['meta_title']['kz'];
            $meta_title->update();
        }else{
            $create_title = new Translate();
            $create_title->ru = $requestData['meta_title']['ru'];
            $create_title->en = $requestData['meta_title']['en'];
            $create_title->kz = $requestData['meta_title']['kz'];
            $create_title->save();
            $article->meta_title = $create_title->id;
            $article->update();
        }

        $meta_description = Translate::where('id', $article->meta_description)->first();
        if($meta_description){
            $meta_description->ru = $requestData['meta_description']['ru'];
            $meta_description->en = $requestData['meta_description']['en'];
            $meta_description->kz = $requestData['meta_description']['kz'];
            $meta_description->update();
        }else{
            $create_description = new Translate();
            $create_description->ru = $requestData['meta_description']['ru'];
            $create_description->en = $requestData['meta_description']['en'];
            $create_description->kz = $requestData['meta_description']['kz'];
            $create_description->save();
            $article->meta_description = $create_description->id;
            $article->update();
        }

        return redirect('admin/article')->with('flash_message', 'Мета данные сохранены');
    }
}
