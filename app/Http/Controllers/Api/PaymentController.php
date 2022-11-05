<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\Halyk;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $request->validate([
            'amount'    =>  'required',
            'invoice_id'    =>  'required',
        ]);
        $pay = new Halyk($request->all());
        $response = $pay->token();
        $decode_data = json_decode($response);

        return response()->json([
            'data'  =>  $decode_data,
        ]);
    }
}
