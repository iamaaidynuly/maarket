<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Order;
use App\Models\OrderAdress;
use App\Models\OrderProducts;
use App\Models\Product;
use App\Models\Translate;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PayStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Session;

class OrderController extends Controller
{
    public function getOrder(Request $request)
    {
        $requestData = $request->all();

        $order_info = new Order();
        $order_info->status = 0;
        $order_info->name = $requestData['main_info']['name'];
        $order_info->phone = $requestData['main_info']['phone'];
        $order_info->email = $requestData['main_info']['email'];
        $order_info->comment = $requestData['main_info']['comment'];
        $user = auth()->user();
        if ($user) {
            $order_info->user_id = $user->id;
        }
        $total_price = 0;

        if ($order_info->save()) {
            foreach ($requestData['products'] as $item) {

                $product = Product::where('id', $item['id'])->first();

                $order_products = new OrderProducts();
                $order_products->order_id = $order_info->id;
                $order_products->product_id = $product->id;
                $order_products->count = $item['count'];
                $order_products->price = $product->current_price;

                $order_products->save();

                $result_price = $item['count'] * $product->current_price;
                $total_price = $total_price + $result_price;
            }

            OrderAdress::create([
                'order_id' => $order_info->id,
                //'region' => $requestData['address']['region'],
                //'city' => $requestData['address']['city'],
                'street' => $requestData['address']['street'],
                'house' => $requestData['address']['house'],
                'building' => $requestData['address']['building'],
                'entrance' => $requestData['address']['entrance'],
                'floor' => $requestData['address']['floor'],
                'apartment' => $requestData['address']['apartment']
            ]);

            $data["amount"] = $total_price * 100;
            $data["login"] = 12377066884694133;
            $data["pass"] = '3FqH4jb5ns3w3xDZx2ap';
            $data["merchantId"] = $data["login"];
            $data['orderId'] = $order_info->id;
            $data["callback"] = 'https://admin.collibri.kz/api/get-order-callback';
            $data['returnUrl'] = 'https://collibri.kz/';
            $data['email'] = $requestData['main_info']['email'];
            $data['phone'] = $requestData['main_info']['phone'];
            //$data['description'] = $requestData['main_info']['comment'];
            //$data['description'] = $requestData['main_info']['comment'];
            $data['demo'] = true;

            return $this->createPayment($data);
        }
    }

    //pass: 3FqH4jb5ns3w3xDZx2ap
    // login: 12377066884694133
    // status
    // 0	Неуспешная транзакция
    // 1	Успешная транзакция
    // 2	Сумма успешно заблокирована (для двухэтапных транзакций)
    // 3	Транзакция отменена или был совершен возврат

    function createPayment($data)
    {

        if (isset($data['metadata'])) {
            $dataArray["metadata"] = $data['metadata'];
        }

        $response = Http::withBasicAuth($data["login"], $data["pass"])->post('https://ecommerce.pult24.kz/payment/create', [
            "merchantId" => strval($data["merchantId"]),
            "callbackUrl" => strval($data["callback"]),
            "orderId" => strval($data['orderId']),
            //"description"=>     strval($data['description']),
            "demo" => $data['demo'],
            "returnUrl" => strval($data['returnUrl']),
            "amount" => (int)$data["amount"],
            "customerData" => [
                'email' => isset($data['email']) ? $data['email'] : "",
                'phone' => isset($data['phone']) ? $data['phone'] : ""
            ]
        ]);

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
        $pay_status->amount = $json->amount / 100;
        $pay_status->commission = $json->commission / 100;
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
}
