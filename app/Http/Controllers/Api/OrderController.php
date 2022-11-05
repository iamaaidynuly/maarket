<?php

namespace App\Http\Controllers\Api;

use Session;
use App\Models\Blog;
use App\Models\City;
use App\Models\User;
use App\Models\Order;
use App\Models\Region;
use App\Models\Product;
use App\Models\PayStatus;
use App\Models\Translate;
use App\Models\OrderAdress;
use Illuminate\Http\Request;
use App\Models\OrderProducts;
use App\Models\ProductImages;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Promocode;
use App\Models\HistPromo;
use App\Models\CallbackPayStatus;
use App\Models\Quantity;

class OrderController extends Controller
{
    public function getOrder(Request $request)
    {
        $requestData = $request->all();
        //dd($requestData);
        $order_info = new Order();
        $order_info->status = 1;
        $order_info->name =  $requestData['main_info']['name'];
        $order_info->l_name =  $requestData['main_info']['l_name'];
        $order_info->phone =  $requestData['main_info']['phone'];
        $order_info->email =  $requestData['main_info']['email'];
        $order_info->comment =  $requestData['main_info']['comment'];
        $order_info->delivery =  $requestData['main_info']['delivery'];
        $order_info->pay_method =  $requestData['main_info']['pay_method'];
        $order_info->date =  $requestData['main_info']['date'];
        if(isset($requestData['main_info']['user_id'])){
            $user = User::where('id', $requestData['main_info']['user_id'])->first();
            $order_info->user_id = $user->id;
        }
        // $user = auth()->user();
        // if(isset($user)){
        //     $order_info->user_id = $user->id;
        // }
        $total_price = 0;

        if($order_info->save()){
            foreach($requestData['products'] as $item){

                $product = Product::where('id', $item['id'])->first();

                $order_products = new OrderProducts();
                $order_products->order_id = $order_info->id;
                $order_products->product_id = $product->id;
                $order_products->count = $item['count'];
                $order_products->price = $product->current_price;
                $order_products->size = $item['size'];
                $order_products->color = $item['color'];
                $order_products->save();

                $result_price = $item['count'] * $order_products->price;
                
                $total_price = $total_price + $result_price;

                // Уменьшаем количество товаров согласно заказа
                $quantity = Quantity::where('product_id', $item['id'])
                                        ->where('color_id', $item['color_id'])
                                        ->where('size_id', $item['size_id'])
                                        ->first();
                $quantity->quantity -= $item['count'];
                if ($quantity->quantity < 0) {
                    $quantity->quantity = 0;
                }
                $quantity->save();


            }

            OrderAdress::create([
                'order_id' => $order_info->id,
                'region' => $requestData['address']['region'],
                'city' => $requestData['address']['city'],
                'street' => $requestData['address']['street'],
                'house' => $requestData['address']['house'],
            ]);

            $data["amount"] = $total_price * 100;
            $data["login"] = 13393354439098592;
            $data["pass"] = 'Uk217k5ZjfV3BXABD7pr';
            $data["merchantId"] = $data["login"];
            $data['orderId'] = $order_info->id;
            $data["callback"] = 'https://admin.celebra.kz/api/get-order-callback';
            $data['returnUrl'] = 'https://celebra.kz/';
            $data['email'] = $requestData['main_info']['email'];
            $data['phone'] = $requestData['main_info']['phone'];
            $data['description'] = $requestData['main_info']['comment'];
            //$data['description'] = $requestData['main_info']['comment'];
            $data['demo'] = true;
            if(isset($requestData['code'])){
                //$user = auth()->user();
                if($user){
                    $update_code_status = Promocode::where('code', $requestData['code'])->where('user_id', $user->id)->first();
                    $hist_promo = new HistPromo();
                    $hist_promo->user_id = $user->id;
                    $hist_promo->code_id = $update_code_status->id;
                    $hist_promo->save();
                }
                else{
                    $update_code_status = Promocode::where('code', $requestData['code'])->first();
                }
                $update_code_status->active = 1;
                $update_code_status->update();
            }
            if(isset($requestData['code'])){
                $update_code_status = Promocode::where('code', $requestData['code'])->first();
                $hist_promo = new HistPromo();
                $hist_promo->user_id = $user->id;
                $hist_promo->code_id = $update_code_status->id;
                $hist_promo->save();
                $update_code_status->active = 1;
                $update_code_status->update();
            }
            //return response()->json(['order_id' => $order_info->id], 200);
            return $this->createPayment($data);
        }
    }

    function createPayment ($data){    
            
        if (isset($data['metadata'])){
            $dataArray["metadata"]=$data['metadata'];
        }

        $response = Http::withBasicAuth($data["login"], $data["pass"])->post('https://ecommerce.pult24.kz/payment/create',[
            "merchantId"=>      strval($data["merchantId"]),
            "callbackUrl"=>     strval($data["callback"]),
            "orderId"   =>      strval($data['orderId']),
            "description"=>     strval($data['description']),
            "demo"      =>      $data['demo'],
            "returnUrl" =>      strval($data['returnUrl']),
            "amount"  =>        (int)$data["amount"],
            "customerData" => [
                'email' => isset($data['email'])?$data['email']:"",
                'phone' => isset($data['phone'])?$data['phone']:""
            ]
        ]);

        return $response;
    }

    function createPaymentTest(Request $request){  
        
        $requestData = $request->all();
        //dd($requestData);
        
        if (isset($data['metadata'])){
            $dataArray["metadata"]=$data['metadata'];
        }

        $response = Http::withBasicAuth($requestData["login"], $requestData["pass"])->post('https://ecommerce.pult24.kz/payment/create',[
            "merchantId"=>      strval($requestData["merchantId"]),
            "callbackUrl"=>     strval($requestData["callback"]),
            "orderId"   =>      strval($requestData['orderId']),
            "description"=>     strval($requestData['description']),
            "demo"      =>      true,
            "returnUrl" =>      strval($requestData['returnUrl']),
            "amount"  =>        (int)$requestData["amount"],
            "customerData" => [
                'email' => isset($requestData['email'])?$requestData['email']:"",
                'phone' => isset($requestData['phone'])?$requestData['phone']:""
            ]
        ]);
        //dd($response);

        return $response;
    }

    public function createPaymentCallback(Request $request)
    {

        $content = file_get_contents('php://input');
        
        $json = json_decode($content);
        $pay_status = new PayStatus();
        $pay_status->transaction_id = $json->id;
        $pay_status->order_id = $json->orderId;
        $pay_status->description = $json->description;
        $pay_status->amount = $json->amount/100;
        $pay_status->commission = $json->commission/100;
        $pay_status->commission_included = $json->commissionIncluded;
        $pay_status->attempt = $json->attempt;
        $pay_status->return_url = $json->returnUrl;
        $pay_status->merchant_id = $json->merchantId;
        $pay_status->invoice_id = $json->invoiceId;
        $pay_status->callback_url = $json->callbackUrl;
        $pay_status->date = $json->date;
        $pay_status->date_out = $json->dateOut;
        $pay_status->demo = $json->demo;
        $pay_status->status = $json->status;
        $pay_status->err_code = $json->errCode;
        $pay_status->err_message = $json->errMessage;
        $pay_status->save();

        return response()->json(['accepted' => true], 200);
    }

    public function paymentCallbackCheck(Request $request)
    {
        $requestData = $request->all();
        
        $pay_status = CallbackPayStatus::where('order_id', (int)$requestData['InvoiceId'])->where('status_type','pay')->first();
        if($pay_status){
            $code = 10;
        }else{
            $code = 0;
        }

        return response()->json(['code' => $code], 200);

    }
    public function paymentCallbackPay(Request $request)
    {
        $requestData = $request->all();
        $pay_status = new CallbackPayStatus();
        $pay_status->status_type = 'pay';
        $pay_status->order_id = (int)$requestData['InvoiceId'];
        $pay_status->data = json_encode($requestData);
        $pay_status->amount = (int)$requestData['Amount'];
        $pay_status->save();
        $order = Order::find((int)$requestData['InvoiceId']);
        $order->pay_status = 1;
        $order->update();

        return response()->json(['code' => 0], 200);
    }
    public function paymentCallbackFail(Request $request)
    {
        $requestData = $request->all();

        $pay_status = new CallbackPayStatus();
        $pay_status->status_type = 'fail';
        $pay_status->order_id = (int)$requestData['InvoiceId'];
        $pay_status->data = json_encode($requestData);
        $pay_status->save();

        return response()->json(['code' => 0], 200);
        
    }
//Uk217k5ZjfV3BXABD7pr

    public function cardProduct(Request $request)
    {
        $requestData = $request->all();
        $lang = request('lang');
        $id = request('product_id');
        $data['products'] = Product::whereIn('products.id', $id)
        ->join('translates as p_title', 'p_title.id', 'products.title')
        ->join('brands', 'brands.id', 'products.brand_id')
        ->join('translates as b_title', 'b_title.id', 'brands.title')
        ->select('products.id','p_title.'.$lang.' as title','b_title.'.$lang.' as brand_name','products.current_price as price', 'products.sale', 'products.created_at')
        ->get();
        foreach($data['products'] as $item){
            $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        }
        

        return response()->json($data);
    }

    public function getRegion(Request $request)
    {
        $lang = request('lang');

        $data['regions'] = Region::join('translates as r_title', 'r_title.id', 'regions.title')
        ->select('regions.id','r_title.'.$lang.' as title')
        ->get();
        return response()->json($data);
    }
    public function getCity(Request $request)
    {
        $lang = request('lang');
        $region_id = request('region_id');

        $data['cities'] = City::where('region_id', $region_id)
        ->join('translates as c_title', 'c_title.id', 'cities.title')
        ->select('cities.id','c_title.'.$lang.' as title')->get();

        return response()->json($data);
    }
}
