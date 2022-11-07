<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function loginPage(Request $request)
    {
        return view('shop.auth.login');
    }

    public function login(Request $request)
    {
        $shop = Shop::where('email', $request['email'])->first();
        if ($shop) {
            if (Hash::check($request['password'], $shop['password'])) {
                session()->put('vK68TF23TfYKYDBZSCC9', 1);
                session()->put('shop', 1);
                session()->put('magazin', $shop);
                session()->save();

                return redirect()->route('shop.main');
            }
            return redirect()->back()->withErrors(['Неправильный пароль!']);
        }

        return redirect()->back()->withErrors(['Пользователь не существует!']);
    }
}
