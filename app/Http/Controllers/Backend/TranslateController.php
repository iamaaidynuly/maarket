<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Translate;
use Illuminate\Http\Request;

class TranslateController extends Controller
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
            $translate = Translate::where('ru', 'LIKE', "%$keyword%")
                ->orWhere('en', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $translate = Translate::latest()->paginate($perPage);
        }

        return view('translate.index', compact('translate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('translate.create');
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
        
        Translate::create($requestData);

        return redirect('admin/translate')->with('flash_message', 'Translate added!');
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
        $translate = Translate::findOrFail($id);

        return view('translate.show', compact('translate'));
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
        $translate = Translate::findOrFail($id);

        return view('translate.edit', compact('translate'));
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
        
        $translate = Translate::findOrFail($id);
        $translate->update($requestData);

        return redirect('admin/translate')->with('flash_message', 'Translate updated!');
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
        Translate::destroy($id);

        return redirect('admin/translate')->with('flash_message', 'Translate deleted!');
    }
}
