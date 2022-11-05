<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Promocode;
use App\Models\User;
use App\Models\Delivery;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\DeclareDeclare;

class PromocodeController extends Controller
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
        $keyword = $request->get('search');
        $perPage = 25;

        $users = User::where('role', 2)->latest()->get();

        if (!empty($keyword)) {
            $promocode = Promocode::join('users', 'users.id', 'promocodes.user_id')
                ->where('promocodes.code', 'LIKE', "%$keyword%")
                ->orWhere('users.name', 'LIKE', "%$keyword%")
                ->orWhere('users.email', 'LIKE', "%$keyword%")
                ->select('promocodes.id', 'promocodes.code', 'promocodes.active', 'promocodes.user_id', 'promocodes.sale')
                ->orderBy('promocodes.id', 'DESC')
                ->paginate($perPage);

            if ($promocode->count() == 0) {
                $promocode = Promocode::where('promocodes.code', 'LIKE', "%$keyword%")
                    ->select('promocodes.id', 'promocodes.code', 'promocodes.user_id', 'promocodes.sale')
                    ->orderBy('promocodes.id', 'DESC')
                    ->paginate($perPage);
            }

        } else {
            $promocode = Promocode::latest()->paginate($perPage);
        }

        return view('admin.promocode.index', compact('promocode', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.promocode.create');
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
        Promocode::create([
            'code' => $request['code'],
            'exp_date' => Carbon::now()->addMonths(3),
            'sale' => $request['sale'],
            'type' => $request['type'],
            'user_id'   =>  $request['user_id'] ?? null,
            'active'    =>  true,
        ]);

        return redirect('admin/promocode')->with('flash_message', 'Промокод создан!');
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
        $promocode = Promocode::findOrFail($id);

        return view('admin.promocode.show', compact('promocode'));
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
        $promocode = Promocode::findOrFail($id);

        return view('admin.promocode.edit', compact('promocode'));
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

        $promocode = Promocode::findOrFail($id);
        $promocode->update($requestData);

        return redirect('admin/promocode')->with('flash_message', 'Promocode updated!');
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
        Promocode::destroy($id);

        return redirect('admin/promocode')->with('flash_message', 'Promocode deleted!');
    }

    public function generateCode($code = NULL)
    {
        $code = Str::random(12);

        $check = Promocode::where('code', $code)->first();

        if ($check) {
            $code = $this->generateCode($code);
        } else {
            if (isset($_REQUEST['type'])) {
                $data['code'] = $code;
                $data['user_id'] = NULL;
                $data['sale'] = $_REQUEST['sale'];
                $data['exp_date'] = $_REQUEST['exp_date'];
                $data['type'] = '1';
                Promocode::create($data);
            }
            return strtoupper($code);
        }
    }

    public function generateCodeCert($code = NULL)
    {
        $code = Str::random(12);

        $check = Promocode::where('code', $code)->first();

        if ($check) {
            $code = $this->generateCodeCert($code);
        } else {
            if ($_REQUEST['type'] == 'cert') {
                $data['code'] = $code;
                $data['user_id'] = 0;
                $data['sale'] = 0;
                $data['sale_price'] = $_REQUEST['sale_price'];
                $data['exp_date'] = $_REQUEST['exp_date_cert'];
                $data['type'] = '2';
                Promocode::create($data);
            }
            return strtoupper($code);
        }
    }

    // public function delivery()
    // {
    //     $delivery = Delivery::first();

    //     return view('admin.delivery.index', compact('delivery'));
    // }

    // public function deliveryUpdate(Request $request)
    // {
    //     $delivery = Delivery::first();
    //     if($delivery){
    //         $delivery->summ = $request->input('summ');
    //         $delivery->update();
    //     }else{
    //         $delivery = new Delivery();
    //         $delivery->summ = $request->input('summ');
    //         $delivery->save();
    //     }

    //     return redirect('admin/delivery')->with('flash_message', 'Условия доставки обновлены!');
    // }
}
