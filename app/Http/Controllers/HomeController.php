<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function edit()
    {
        return view('user.edit');
    }

    public function save(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ],
            [
                'password.required' => 'Пароль обязательно для заполнения',
                'password.min' => 'Минимальная длина пароля 6 символов',
                'password_confirmation.required' => 'Подтвердите новый пароль',
                'password.confirmed' => 'Пароли не совпадают'
            ]);

        $user = Auth::user();

        $user = User::find($user->id);
        $user->password = Hash::make(request('password'));
        if ($user->update()) {
            return redirect('admin/edit')->with('success', 'Пароль изменен');
        } else {
            return redirect('admin/edit')->with('error', 'Ошибка изменения пароля');
        }
    }

    public function upload(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'upload' => 'required|mimes:doc,docx,xls,xlsx,ppt,pdf,zip,jpeg,png,jpg,gif,svg|max:2048',
        ],
            [
                'upload.required' => 'Загрузите файл',
                'upload.mimes' => 'Проверьте формат файла (doc,docx,xls,xlsx,ppt,pdf,zip,jpeg,png,jpg,gif,svg)',
                'upload.max' => 'Размер файла не может превышать 2МБ'
            ]);

        $funcNum = $request->input('CKEditorFuncNum');

        if ($request->file('upload')) {

            $image = $request->file('upload');
            $name = time() . '.' . $image->extension();
            $path = 'uploads';
            $image->storeAs($path, $name, 'static');

            $url = asset(\Config::get('constants.alias.cdn_url') . '/uploads/' . $name);
        }


        return response(
            "<script>
                window.parent.CKEDITOR.tools.callFunction({$funcNum}, '{$url}', 'Файл успешно загружен');
            </script>"
        );
    }

    public function apiUpdateStatus(Request $request)
    {
        $requestData = $request->all();
        if ($requestData['type'] == 'product') {
            $data = Product::find($requestData['id']);
            $data->best = $requestData['status'];
            $data->update();
        }
        if ($requestData['type'] == 'brand') {
            $data = Brand::find($requestData['id']);
            $data->popular = $requestData['status'];
            $data->update();
        }
        if ($requestData['type'] == 'product_new') {
            $data = Product::find($requestData['id']);
            $data->new = $requestData['status'];
            $data->update();
        }
        if ($request['type'] == 'funds_1') {
            $data = Product::find($requestData['id']);
            $data->funds_1 = $requestData['status'];
            if ($requestData['status'] == 1) {
                $data->funds_2 = 0;
            }
            $data->update();
        }
        if ($request['type'] == 'funds_2') {
            $data = Product::find($requestData['id']);
            $data->funds_2 = $requestData['status'];
            if ($requestData['status'] == 1) {
                $data->funds_1 = 0;
            }
            $data->update();
        }

        return true;
    }
}
