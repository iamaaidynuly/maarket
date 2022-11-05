<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Models\Product;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mail;
use App\Models\Click;
use App\Models\Admission;

class FeedbackApiController extends Controller
{
    // public function getAddress(Request $request){
    //     $lang = request('lang');

    //     $data['addres'] = Contact::join('translates as company', 'company.id', 'contacts.company')
    //     ->join('translates as address', 'address.id', 'contacts.address')
    //     ->select('contacts.id','contacts.phone_number','company.'.$lang.' as company','address.'.$lang.' as address','contacts.youtube','contacts.instagram','contacts.facebook','contacts.vk','contacts.odnoklassniki')
    //     ->orderBy('contacts.id', 'DESC')->first();
    //     return response()->json($data);
    // }

    public function feedback(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
            'text' => 'required',
        ]);
        $feedback = Feedback::create([
            'name' => $request['name'],
            'phone_number' => $request['email'],
            'type' => $request['message'],
            'text' => $request['text'],
        ]);


        return response()->json([
            'data' => $feedback,
        ], 201);
    }

    public function click(Request $request)
    {
        $requestData = $request->all();

        $click = new Click();
        $click->product_id = $requestData['product_id'];
        $click->phone_number = $requestData['phone'];

        if ($click->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function admission(Request $request)
    {
        $requestData = $request->all();

        $admission = new Admission();
        $admission->product_id = $requestData['product_id'];
        $admission->phone_number = $requestData['phone'];

        if ($admission->save()) {
            return true;
        } else {
            return false;
        }
    }

}
