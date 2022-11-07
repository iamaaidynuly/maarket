<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function main(Request $request)
    {
        $magazin = session()->get('magazin');

        return view('shop.main', compact('magazin'));
    }
}
