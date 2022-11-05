<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserFavouriteResource;
use App\Models\Order;
use App\Models\OrderAdress;
use App\Models\OrderProducts;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\UserFavourite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function putFavourite(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'lang' => 'required',
        ]);
        $user = auth()->user();
        if (UserFavourite::where('user_id', $user->id)->where('product_id', $request['product_id'])->exists()) {
            return response()->json([
                'message' => 'Already exists!',
            ], 400);
        }
        $fav = UserFavourite::create([
            'user_id' => $user->id,
            'product_id' => $request['product_id'],
            'created_at' => Carbon::now()
        ]);

        return response()->json([
            'data' => $fav,
        ], 201);
    }

    public function getFavourite(Request $request)
    {
        $request->validate([
            'lang' => 'required',
        ]);
        $user = auth()->user();
        $favs = UserFavourite::where('user_id', $user->id)->get();

        return response()->json([
            'data' => UserFavouriteResource::collection($favs),
        ], 200);
    }

    public function deleteFavourite(Request $request)
    {
        $request->validate([
            'user_favourite_id' => 'required|exists:user_favourites,id',
        ]);
        UserFavourite::find($request['user_favourite_id'])->delete();

        return response()->json([
            'message' => 'Successfully deleted!',
        ], 200);
    }

    public function promocode(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:promocodes,code',
            'price' => 'required',
        ], [
            'code.exists' => 'Промокод не существует'
        ]);
        $promocode = Promocode::where('code', $request->code)->first();
        if ($promocode->active != true) {
            return response()->json([
                'message' => 'Промокод не активный'
            ], 400);
        }
        $price = $request['price'];
        $procent = ($promocode->sale * $price) / 100;

        if ($promocode->type == 1) {
            if ($request->bearerToken() == null) {
                return response()->json([
                    'message' => 'Нет доступа!'
                ], 400);
            }
            $token = PersonalAccessToken::findToken($request->bearerToken());
            $user = \App\Models\User::find($token->tokenable_id);
            if ($promocode->user_id == $user->id) {
                $promocode->fill([
                    'active' => false,
                ])->save();
                return response()->json([
                    'new_price' => $price - $procent,
                    'percent' => $promocode->sale,
                    'type' => $promocode->type,
                ]);
            } else {
                return response()->json([
                    'message' => 'Не твой промокод'
                ], 400);
            }
        } else {
            $promocode->fill([
                'active' => false,
            ])->save();

            return response()->json([
                'new_price' => $price - $procent,
                'percent' => $promocode->sale,
                'type' => $promocode->type,
            ]);
        }
    }

    public function order(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'delivery_type' => 'required',
            'payment_type' => 'required',
            'delivery_date' => 'required',
            'total_price' => 'required',
        ]);
        $user = auth()->user();
        $order = Order::create([
            'name' => $request['name'],
            'l_name' => $request['surname'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'created_at' => Carbon::now(),
            'comment' => $request['comment'],
            'date' => $request['delivery_date'],
            'pay_method' => $request['payment_type'],
            'status' => $request['payment_status'] == 1 ? 2 : 5,
            'delivery' => $request['delivery_type'],
            'count' => $request['product_count'],
            'user_id' => $user->id,
            'pay_status' => $request['payment_status'],
            'total_price' => $request['total_price'],
            'promocode' => $request['promocode'] ?? null,
        ]);
        $products = $request->products;
        foreach ($products as $product) {
            $price = Product::find($product['id'])->current_price;
            $funds1 = $product['funds_1'] ?? null;
            $funds2 = $product['funds_2'] ?? null;
            OrderProducts::insert([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'count' => $product['count'],
                'created_at' => Carbon::now(),
                'funds_1'   =>  isset($funds1) ? 1 : 0,
                'funds_2'   =>  isset($funds2) ? 1 : 0,
                'price' =>  $price * $product['count'],
                'funds_1_bonus' =>  isset($funds1) ? $product['free'] : 0,
                'funds_2_bonus' =>  isset($funds2) ? $product['bonus'] : 0,
            ]);
        }
        if ($request->delivery_type == 'delivery') {
            OrderAdress::insert([
                'order_id' => $order->id,
                'region' => $request['region_id'],
                'city' => $request['city_id'],
                'street' => $request['street'],
                'house' => $request['house'],
                'created_at' => Carbon::now(),
            ]);
        }

        return response()->json([
            'data' => $order,
        ], 201);
    }

    public function orders(Request $request)
    {
        $request->validate([
            'lang' => 'required',
        ]);
        $lang = $request->lang;
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->get();

        return response()->json([
            'data' => OrderResource::collection($orders),
        ]);
    }
}
