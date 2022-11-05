<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserFavourite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Securities\Price;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->text)) {
            $users = User::where('role', 2)->where('name', 'like', '%' . $request->text . '%')
                ->orWhere('email', 'like', '%' . $request->text . '%')
                ->orderBy('created_at', 'desc')->paginate(15);

            return view('admin.users.index', compact('users'));
        }
        $users = User::where('role', 2)->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        User::create([
            'name' => $request['name'],
            'lname' => $request['l_name'],
            'phone_number' => $request['phone_number'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'type' => $request['type'],
            'email_verified_at' => $request['email_verified'] == 1 ? Carbon::now() : null,
            'discount' => $request['discount'] ?? 0,
        ]);

        return redirect()->route('users.index')->with('success', 'Успешно добавлено');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $addresses = UserAddress::where('user_id', $user->id)->get();
        $favs = UserFavourite::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('admin.users.show', compact('user', 'addresses', 'favs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $priceTypes = PriceType::get();

        return view('admin.users.edit', compact('user', 'priceTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $user->update([
            'name' => $request['name'],
            'lname' => $request['l_name'],
            'phone_number' => $request['phone_number'],
            'email' => $request['email'],
            'type' => $request['type'],
            'email_verified_at' => isset($request['email_verified']) ? Carbon::now() : null,
            'discount' => $request['discount'] ?? $user->discount,
            'price_type_id' => $request['price_type_id'] ?? $user->price_type_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Успешно обновлено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        Promocode::where('user_id', $id)->delete();

        return redirect()->route('users.index')->with('success', 'Успешно удалено');
    }

    public function export($id)
    {
        $user = User::find($id);

        return view('admin.users.export', compact('user'));
    }

    public function exportOrder(Request $request, $id)
    {
        $from = $request->from;
        $to = $request->to;

        return \Maatwebsite\Excel\Facades\Excel::download(new UserExport($id, $from, $to), 'Отчетопользователе.xlsx');

    }
}
