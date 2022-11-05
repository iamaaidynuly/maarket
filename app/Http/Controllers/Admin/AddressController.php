<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Translate;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::get();

        return view('address.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::get();

        return view('address.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $title = Translate::create([
            'ru'    =>  $request['title']['ru'],
            'kz'    =>  $request['title']['kz'],
            'en'    =>  $request['title']['en'],
        ]);
        $address = Address::create([
            'adds'  =>  $title->id,
            'city_id'   =>  $request['city'],
        ]);

        return redirect()->route('addresses.index')->with('success', 'Успешно добавлено');
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
        $address = Address::find($id);
        $cities = City::get();

        return view('address.edit', compact('address', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $address = Address::find($id);
        Translate::find($address->adds)->update([
            'ru'    =>  $request['title']['ru'],
            'kz'    =>  $request['title']['kz'],
            'en'    =>  $request['title']['en'],
        ]);
        $address->update([
            'city_id'   =>  $request['city'],
        ]);

        return redirect()->route('addresses.index')->with('success', 'Успешно обновлено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Address::find($id)->delete();

        return redirect()->route('addresses.index')->with('success', 'Успешно удалено');

    }
}
