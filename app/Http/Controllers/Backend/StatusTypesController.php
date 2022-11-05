<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Models\Translate;

use App\Models\StatusType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusTypesController extends Controller
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

            $statustypes = StatusType::latest()->paginate($perPage);

        return view('status-types.index', compact('statustypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('status-types.create');
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
        
        $name = new Translate();
        $name->ru = $requestData['name']['ru'];
        $name->en = $requestData['name']['en'];
        $name->kz = $requestData['name']['kz'];

        if ($name->save()) {
            $statustype = new StatusType();
            $statustype->name = $name->id;
            $statustype->save();
        }


        return redirect('admin/status-types')->with('flash_message', 'Статус добавлена!');
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
        $statustype = StatusType::findOrFail($id);

        return view('status-types.show', compact('statustype'));
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
        $statustype = StatusType::findOrFail($id);

        return view('status-types.edit', compact('statustype'));
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
        $statustype = StatusType::findOrFail($id);

        $name = Translate::find($statustype->name);
        $name->ru = $requestData['name']['ru'];
        $name->en = $requestData['name']['en'];
        $name->kz = $requestData['name']['kz'];
        $name->update();

        return redirect('admin/status-types')->with('flash_message', 'Статус изменена!');
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
        $statustype = StatusType::find($id);
        $name = Translate::find($statustype->name);
        $name->delete();
        $statustype->delete();

        return redirect('admin/status-types')->with('flash_message', 'Статус удалена!');
    }
}
