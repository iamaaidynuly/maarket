<?php

namespace App\Http\Controllers\Backend;

use App\Models\Contacts;
use App\Models\Translate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function Sodium\add;

class ContactsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = 25;
        $contacts = Contacts::latest()->paginate($perPage);

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $requestd
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $title = new Translate();
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        $title->save();
        $description = new Translate();
        $description->ru = $requestData['description']['ru'];
        $description->en = $requestData['description']['en'];
        $description->kz = $requestData['description']['kz'];
        $description->save();
        // $address = new Translate();
        // $address->ru = $requestData['address']['ru'];
        // $address->en = $requestData['address']['en'];
        // $address->kz = $requestData['address']['kz'];
        // $address->save();

        $contacts = new Contacts();
        $contacts->title = $title->id;
        $contacts->description = $description->id;
        //$contacts->address = $address->id;
        $contacts->email = $requestData['email'];
        $contacts->whats_app = $requestData['whats_app'];
        $contacts->telegram = $requestData['telegram'];
        $contacts->instagram = $requestData['instagram'];
        $contacts->phone_number = serialize($requestData['phone_number']);
        $contacts->address = serialize($requestData['address']);
        $contacts->save();

        return redirect('admin/contacts')->with('flash_message', 'Контакт добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contacts::findOrFail($id);

        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contacts::findOrFail($id);

        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        $contact = Contacts::findOrFail($id);
        $title = Translate::find($contact->title);
        $title->ru = $requestData['title']['ru'];
        $title->en = $requestData['title']['en'];
        $title->kz = $requestData['title']['kz'];
        $title->update();
        $description = Translate::find($contact->description);
        $description->ru = $requestData['description']['ru'];
        $description->en = $requestData['description']['en'];
        $description->kz = $requestData['description']['kz'];
        $description->update();
        if (isset($contact->main_address)) {
            $address = Translate::find($contact->main_address);
            $address->ru = $requestData['main_address']['ru'];
            $address->en = $requestData['main_address']['en'];
            $address->kz = $requestData['main_address']['kz'];
            $address->update();
        } else {
            $address = new Translate();
            $address->ru = $requestData['main_address']['ru'];
            $address->en = $requestData['main_address']['en'];
            $address->kz = $requestData['main_address']['kz'];
            $address->save();

            $contact->main_address = $address->id;
        }
        $contact->email = $requestData['email'];
        $contact->whats_app = $requestData['whats_app'];
        $contact->telegram = $requestData['telegram'];
        $contact->instagram = $requestData['instagram'];
        $contact->address = serialize($requestData['address']);
        $contact->phone_number = serialize($requestData['phone_number']);
        $contact->vk = $requestData['vk'];
        $contact->facebook = $requestData['facebook'];
        $contact->map = $requestData['map'];
        $contact->retail_sale = $requestData['retail_sale'];
        $contact->wholesale = $requestData['wholesale'];

        $contact->update();

        return redirect('admin/contacts')->with('flash_message', 'Cохранен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contacts::findOrFail($id);

        $title = Translate::find($contact->title);
        $title->delete();

        $description = Translate::find($contact->description);
        $description->delete();

        $contact->delete();

        return redirect('admin/contacts')->with('flash_message', 'Удален');
    }

    public function editSeo($id)
    {
        $contacts = Contacts::findOrFail($id);
        return view('contacts.meta_seo', compact('contacts'));
    }

    public function updateSeo(Request $request, $id)
    {
        $requestData = $request->all();
        $contact = Contacts::findOrFail($id);

        $meta_title = Translate::where('id', $contact->meta_title)->first();
        if ($meta_title) {
            $meta_title->ru = $requestData['meta_title']['ru'];
            $meta_title->en = $requestData['meta_title']['en'];
            $meta_title->update();
        } else {
            $create_title = new Translate();
            $create_title->ru = $requestData['meta_title']['ru'];
            $create_title->en = $requestData['meta_title']['en'];
            $create_title->save();
            $contact->meta_title = $create_title->id;
            $contact->update();
        }

        $meta_description = Translate::where('id', $contact->meta_description)->first();
        if ($meta_description) {
            $meta_description->ru = $requestData['meta_description']['ru'];
            $meta_description->en = $requestData['meta_description']['en'];
            $meta_description->update();
        } else {
            $create_description = new Translate();
            $create_description->ru = $requestData['meta_description']['ru'];
            $create_description->en = $requestData['meta_description']['en'];
            $create_description->save();
            $contact->meta_description = $create_description->id;
            $contact->update();
        }

        return redirect('admin/contacts')->with('flash_message', 'Мета данные сохранены');
    }
}
