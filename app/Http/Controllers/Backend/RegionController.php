<?php

namespace App\Http\Controllers\Backend;

use App\Models\City;
use App\Http\Requests;

use App\Models\Region;
use App\Models\Translate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
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
        $region = Region::latest()->paginate($perPage);

        return view('region.index', compact('region'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('region.create');
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
        $title->kz = $requestData['title']['kz'];
        $title->en = $requestData['title']['en'];

        if ($title->save()) {
            $region = new Region();
            $region->title = $title->id;
            $region->save();
        }

        return redirect('admin/region')->with('flash_message', 'Область добавлен');
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
        $region = Region::findOrFail($id);

        return view('region.edit', compact('region'));
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

        $requestData = $request->all();

        $region = Region::findOrFail($id);
        $title = Translate::find($region->title);
        $title->ru = $requestData['title']['ru'];
        $title->kz = $requestData['title']['kz'];
        $title->en = $requestData['title']['en'];
        $title->update();

        return redirect('admin/region')->with('flash_message', 'Область изменен');
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
        Region::destroy($id);

        return redirect('admin/region')->with('flash_message', 'Область удален!');
    }

    public function cities($id)
    {
        $region = Region::findOrFail($id);
        $city = City::where('region_id', $id)->get();

        return view('region.city', compact('city', 'region'));
    }

    public function citiesStore(Request $request, $id)
    {
        $requestData = $request->all();
        //dd($requestData);

        $title = new Translate();
        $title->ru = $requestData['title']['ru'];
        $title->kz = $requestData['title']['kz'];
        $title->en = $requestData['title']['en'];
        $title->save();
        $city = new City();
        $city->region_id = $id;
        $city->title = $title->id;

        if ($city->save()) {
            return redirect('admin/cities/' . $id)->with('flash_message', 'Значение добавлено');
        } else {
            return redirect('admin/cities/' . $id)->with('error', 'Возникла ошибка при добавлении');
        }

    }

    public function citiesUpdate(Request $request, $id)
    {
        $requestData = $request->all();

        $city = City::find($id);
        $title = Translate::find($city->title);
        $title->ru = $requestData['title']['ru'];
        $title->kz = $requestData['title']['kz'];
        $title->en = $requestData['title']['en'];
        $title->update();


        if ($title->update()) {
            return redirect('admin/cities/' . $requestData['region_id'])->with('flash_message', 'Значение добавлено');
        } else {
            return redirect('admin/cities/' . $requestData['region_id'])->with('error', 'Возникла ошибка при добавлении');
        }
    }

    public function citiesDelete($id)
    {
        $city = City::find($id);
        $title = Translate::find($city->title);
        $title->delete();

        $region_id = $city->region_id;
        if ($city->delete()) {
            return redirect('admin/cities/' . $region_id)->with('flash_message', 'Значение удалено');
        } else {
            return redirect('admin/cities/' . $region_id)->with('error', 'Возникла ошибка при удалении');
        }

    }
}
