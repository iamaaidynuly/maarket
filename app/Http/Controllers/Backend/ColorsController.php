<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Translate;

use App\Models\Color;
use App\Models\ColorRelations;
use Illuminate\Http\Request;

class ColorsController extends Controller
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
            $colors = Color::where('title', 'LIKE', "%$keyword%")
                ->orWhere('code', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $colors = Color::latest()->paginate($perPage);
        }

        return view('colors.index', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('colors.create');
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
        $title = new Translate();
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        if ($title->save()) {
            $color = new Color();
            $color->title = $title->id;
            $color->code = $requestData['code'];
            $color->save();
        }
        

        return redirect('admin/colors')->with('flash_message', 'Цвет добавлен');
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
        $color = Color::findOrFail($id);

        return view('colors.edit', compact('color'));
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
        
        $color = Color::findOrFail($id);
        $title = Translate::find($color->title);
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        if ($title->update()){
            $color->code = $requestData['code']; 
        }
        $color->update();

        return redirect('admin/colors')->with('flash_message', 'Цвет изменен');
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
        $color = Color::find($id);
        $title = Translate::find($color->title);
        $color_relations = ColorRelations::where('color_id', $id)->get();
        $title->delete();
        if ($color->delete() && $color_relations) {
            foreach ($color_relations as $value) {
                $value->delete();
            }
        }
        return redirect('admin/colors')->with('flash_message', 'Цвет удален');
    }
}
