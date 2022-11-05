<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderAdress;
use App\Models\OrderProducts;
use App\Models\StatusType;
use App\Models\User;
use Illuminate\Http\Request;


class OrdersController extends Controller
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

        $orders = Order::latest()->paginate($perPage);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $product = Product::all();
        $status = StatusType::all();

        return view('orders.create', compact('product', 'status'));
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
        $orders = new Order();
        $orders->name = $requestData['name'];
        $orders->l_name = $requestData['l_name'];
        $orders->phone = $requestData['phone'];
        $orders->email = $requestData['email'];
        $orders->comment = $requestData['comment'];
        //$orders->product_id = $requestData['product_id'];
        $orders->count = $requestData['count'];
        $orders->status = $requestData['status'];
        $orders->pay_status = $requestData['pay_status'];
        $orders->save();
        $order_adress = new OrderAdress();
        $order_adress->order_id = $orders->id;
        $order_adress->region = $requestData['region'];
        $order_adress->city = $requestData['city'];
        $order_adress->street = $requestData['street'];
        $order_adress->house = $requestData['house'];
        $order_adress->save();
        //$orders->status = $requestData['status'];
        //$orders->pay_status = $requestData['pay_status'];

        //Order::create($requestData);

        return redirect('admin/orders')->with('flash_message', 'Заказ добавлен!');
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
        $order = Order::findOrFail($id);
        $product = Product::find($order->product_id);
        $adress = OrderAdress::where('order_id', $id)->first();
        $user = User::where('id', $order->user_id)->first();//findOrFail($order->user_id);
        $order_products = OrderProducts::where('order_id', $id)->join('products', 'products.id', 'order_products.product_id')
            ->join('translates', 'translates.id', 'products.title')
            ->select('translates.ru as title', 'order_products.count as count', 'order_products.price as price', 'order_products.id', 'order_products.funds_1', 'order_products.funds_2', 'order_products.funds_1_bonus', 'order_products.funds_2_bonus')
            ->get();

        return view('orders.show', compact('order', 'product', 'adress', 'order_products', 'user'));
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
        $order = Order::findOrFail($id);
        $product = Product::all();
        $order_adress = OrderAdress::where('order_id', $id)->first();
        $status = StatusType::all();
        return view('orders.edit', compact('order', 'product', 'order_adress', 'status'));
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
        $orders = Order::findOrFail($id);
        $orders->name = $requestData['name'];
        $orders->l_name = $requestData['l_name'];
        $orders->phone = $requestData['phone'];
        $orders->email = $requestData['email'];
        $orders->comment = $requestData['comment'];
        //$orders->product_id = $requestData['product_id'];
        $orders->status = $requestData['status'];
        $orders->pay_status = $requestData['pay_status'];
        $orders->count = $requestData['count'];
        $orders->update();

        $order_adress = OrderAdress::where('order_id', $id)->first();
        if ($order_adress) {
            $order_adress->region = $requestData['region'];
            $order_adress->city = $requestData['city'];
            $order_adress->street = $requestData['street'];
            $order_adress->house = $requestData['house'];
            $order_adress->update();
        } else {
            $order_adress = new OrderAdress();
            $order_adress->order_id = $orders->id;
            $order_adress->region = $requestData['region'];
            $order_adress->city = $requestData['city'];
            $order_adress->street = $requestData['street'];
            $order_adress->house = $requestData['house'];
            $order_adress->save();
        }


        //$order->update($requestData);

        return redirect('admin/orders')->with('flash_message', 'Заказ обновлен!');
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
        $order_adress = OrderAdress::where('order_id', $id)->get();

        Order::destroy($id);

        if ($order_adress) {
            foreach ($order_adress as $item) {
                $item->delete();
            }
        }
        OrderProducts::where('order_id', $id)->delete();

        return redirect('admin/orders')->with('flash_message', 'Заказ удален!');
    }

    public function productsItems($id)
    {
        $order = Order::findOrFail($id);
        $product = Product::all();
        $order_products = OrderProducts::where('order_id', $id)->orderBy('id')->get();
        //$filter_items = FilterItems::where('filter_id', $id)->get();
        // dd($id, $filter,$filter_items);
        return view('orders.products_items', compact('order', 'product', 'order_products'));
    }

    public function productsItemsStore(Request $request, $id)
    {
        $requestData = $request->all();

        $order_products = new OrderProducts();
        $order_products->order_id = $id;
        $order_products->product_id = $requestData['product_id'];
        $order_products->count = $requestData['count'];
        $order_products->price = $requestData['price'];
        $order_products->funds_1_bonus = $requestData['funds_1_bonus'] ?? 0;
        $order_products->funds_2_bonus = $requestData['funds_2_bonus'] ?? 0;
        if (isset($order_products->funds_1_bonus)) {
            $order_products->funds_1 = true;
        }
        if (isset($order_products->funds_2_bonus)) {
            $order_products->funds_2 = true;
        }

        if ($order_products->save()) {
            return redirect('admin/products-items/' . $id)->with('flash_message', 'Значение добавлено');
        } else {
            return redirect('admin/products-items/' . $id)->with('error', 'Возникла ошибка при добавлении');
        }

    }

    public function productsItemsUpdate(Request $request, $id)
    {
        $requestData = $request->all();
        $order_products = OrderProducts::find($id);
        $order_products->product_id = $requestData['product_id'];
        $order_products->count = $requestData['count'];
        $order_products->price = $requestData['price'];
        $order_products->funds_1_bonus = $requestData['funds_1_bonus'] ?? 0;
        $order_products->funds_2_bonus = $requestData['funds_2_bonus'] ?? 0;
        if (isset($order_products->funds_1_bonus)) {
            $order_products->funds_1 = true;
        }
        if (isset($order_products->funds_2_bonus)) {
            $order_products->funds_2 = true;
        }


        if ($order_products->update()) {
            return redirect('admin/products-items/' . $requestData['order_id'])->with('flash_message', 'Значение добавлено');
        } else {
            return redirect('admin/products-items/' . $requestData['order_id'])->with('error', 'Возникла ошибка при добавлении');
        }
    }

    public function productsItemsDelete($id)
    {
        $order_products = OrderProducts::find($id);
        $order_id = $order_products->order_id;
        if ($order_products->delete()) {
            return redirect('admin/products-items/' . $order_id)->with('flash_message', 'Значение удалено');
        } else {
            return redirect('admin/products-items/' . $order_id)->with('error', 'Возникла ошибка при удалении');
        }

    }

    public function export()
    {
        return view('orders.export');
    }
}
