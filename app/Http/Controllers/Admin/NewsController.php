<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Translate;
use Carbon\Carbon;
use Carbon\PHPStan\AbstractMacro;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::get();

        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = Translate::create([
            'ru'    =>  $request['title']['ru'],
            'kz'    =>  $request['title']['kz'],
            'en'    =>  $request['title']['en'],
        ]);
        $description = Translate::create([
            'ru'    =>  $request['content']['ru'],
            'kz'    =>  $request['content']['kz'],
            'en'    =>  $request['content']['en'],
        ]);
        if ($request->hasFile('image')) {
            $name = time().'.'.$request['image']->extension();
            $path = 'brand';
            $image = $request->file('image')->storeAs($path, $name, 'static');
        }
        $news = News::create([
            'title' =>  $title->id,
            'description'   =>  $description->id,
            'image' =>  $image,
            'shows' =>  $request->shows,
            'created_at'    =>  Carbon::now(),
        ]);

        return redirect()->route('news.index')->with('success', 'Успешно добавлено');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companyNew = News::find($id);

        return view('news.edit', compact('companyNew'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $companyNew = News::find($id);
        Translate::find($companyNew->title)->update([
            'ru'    =>  $request['title']['ru'],
            'kz'    =>  $request['title']['kz'],
            'en'    =>  $request['title']['en'],
        ]);
        Translate::find($companyNew->description)->update([
            'ru'    =>  $request['content']['ru'],
            'kz'    =>  $request['content']['kz'],
            'en'    =>  $request['content']['en'],
        ]);
        if ($request->hasFile('image')) {
            $name = time().'.'.$request['image']->extension();
            $path = 'brand';
            $image = $request->file('image')->storeAs($path, $name, 'static');
        }
        $companyNew->update([
            'shows' =>  $request['shows'] ?? $companyNew->shows,
            'image' =>  $image ?? $companyNew->image,
        ]);

        return redirect()->route('news.index')->with('success', 'Успешно обновлено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        News::destroy($id);

        return redirect()->route('news.index')->with('success', 'Успешно удалено');
    }
}
