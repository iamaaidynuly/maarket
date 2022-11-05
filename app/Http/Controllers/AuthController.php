<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Mail\AuthCodeMail;
use App\Models\CallbackPayStatus;
use App\Models\UserAddress;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderAdress;
use App\Models\OrderProducts;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\PasswordResets;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Promocode;
use App\Models\HistPromo;
use App\Models\Review;
use Illuminate\Support\Facades\Http;
use Exception;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Extension\Attributes\Util\AttributesHelper;
use PHPUnit\Framework\Constraint\Callback;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'resendCode', 'codeConfirm', 'login', 'register', 'login', 'sendSms', 'logout', 'userUpdate', 'passwordUpdate', 'me', 'address', 'editAddress', 'deleteAddress',
                'review', 'reset', 'checkCode', 'newPassword', 'editReview', 'deleteReview'
            ]]);
        $this->guard = "api";
    }

    public function editReview(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'review_id' => 'required|exists:reviews,id'
        ], [
            'review_id.exists' => 'Отзыва не существует'
        ]);
        $user = \auth()->user();
        $review = Review::find($request['review_id']);
        if ($review->user_id != $user->id) {
            return response()->json([
                'message' => 'Нет доступа'
            ], 400);
        }
        $review->update([
            'review' => $request['comment'],
        ]);

        return response()->json([
            'message' => 'Изменено'
        ], 202);
    }

    public function deleteReview(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:reviews,id'
        ], [
            'review_id.exists' => 'Отзыва не существует'
        ]);
        $user = \auth()->user();
        $review = Review::find($request['review_id']);
        if ($review->user_id != $user->id) {
            return response()->json([
                'message' => 'Нет доступа'
            ], 400);
        }
        $review->update([
            'status' => 'declined',
        ]);

        return response()->json([
            'message' => 'Удалено'
        ], 202);
    }


    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email'
        ], [
            'email.exists' => 'Неправильный логин!'
        ]);
        $code = 1111;
        \Mail::to($request['email'])->send(new AuthCodeMail($code));
        \Cache::put($request['email'], $code, 3600);

        return response()->json([
            'message' => 'Отправлено',
        ], 202);
    }

    public function checkCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required|exists:users,email'
        ]);
        $cache = \Cache::get($request['email']);
        if (isset($cache)) {
            if ($cache == $request['code']) {
                $user = User::where('email', $request['email'])->first();
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'data' => $user,
                    'access_token' => $token
                ], 200);
            }
        }

        return response()->json([
            'message' => 'Неверный логин!'
        ], 400);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ], [
            'email.exists' => 'Логин не существует'
        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Неверный пароль'
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'message' => 'Успешно'
        ], 202);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(['data' => new UserResource(\auth()->user())]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function sendSms($code, $phone)
    {

        $send_sms = Http::withBasicAuth('alure', 'WHaNlxDDD')->accept('application/json')->post('http://isms.center/api/sms/send', [
            'from' => 'Celebra',
            'to' => $phone,
            'text' => $code,
        ]);

        return true;
    }

    // public function sendSms($code = null, $phone = null)
    // {

    //     $send_sms = Http::withBasicAuth('alure', 'WHaNlxDDD')->accept('application/json')->post('http://isms.center/api/sms/send',[
    //         'from' => 'Celebra',
    //         'to' => '87080000555',
    //         'text' => 'test',
    //     ]);

    //     return true;
    // }

    /**
     * User registration
     */
    public function register(RegisterRequest $request)
    {
        $check_user = User::where('phone_number', $request['phone'])->first();
        if ($check_user) {
            return response()->json([
                'message' => 'Пользователь уже существует'
            ], 400);
        }

        try {
            $user = User::create([
                'name' => $request['name'],
                'sname' => $request['surname'],
                'phone_number' => $request['phone'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'type' => $request['type'],
                'bin' => $request['bin'],
                'actual_address' => $request['actual_address'],
                'entity_address' => $request['entity_address'],
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'data' => $user,
                'access_token' => $token,
            ], 201);
        } catch (Exception $e) {
            return response()->json('Ошибка при сохранении, ' . $e->getMessage());
        }
    }

    public function codeConfirm()
    {
        $user = User::where('code', request('code'))->where('code_activate', 0)->first();
        if ($user) {
            $dateDiff = \Carbon\Carbon::now()->diffInMinutes($user->code_date, false);
            if ($dateDiff < -5) {
                return response()->json(['dateDiff' => $dateDiff, 'more' => 5], 400);
            }

            $user->code_activate = 1;
            $user->update();
            $token = auth($this->guard)->login($user);

            return response()->json(['token' => $token, 'register_finish' => $user->register_finish], 200);
        } else {
            return response()->json(['Неправильный код'], 400);
        }
    }

    public function resendCode()
    {

        $user = User::where('phone_number', request('phone'))->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 500);
        }

        $code = $this->generateSmsCode();
        $user->phone_number = request('phone');
        //$user->phone_secret = request('phone');
        $user->code = $code;
        $user->code_activate = 0;
        $user->code_date = \Carbon\Carbon::now();
        $user->update();
        $phone = request('phone');

        $this->sendSms($code, $phone);

        return response()->json(['success' => 'Новый код отправлен'], 200);
    }

    // Генерация смс кода
    function generateSmsCode()
    {
        $code = mt_rand(1000, 9999);

        if ($this->barcodeSmsCodeExists($code)) {
            return $this->generateBarcodeNumber();
        }

        return $code;
    }

    // Проверка на уникальность смс кода
    function barcodeSmsCodeExists($code)
    {
        return User::where('code', $code)->exists();

    }

    public function userPromocode(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            //$promocode = Promocode::where('user_id', $user->id)->whereNull('active')->first();
            $data['history'] = HistPromo::join('promocodes', 'promocodes.id', 'hist_promo.code_id')->where('hist_promo.user_id', $user->id)
                ->select('hist_promo.id', 'promocodes.code', 'promocodes.created_at', 'hist_promo.created_at')
                ->get();
            return response()->json([
                'promocode' => $data
            ], 200);
        } else {
            return response()->json([
                'message' => 'У вас нет доступа к данной странице'
            ], 403);
        }
    }

    public function review(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'review' => 'required',
            'rating' => 'required',
            'product_id' => 'required|exists:products,id',
        ]);
        $requestData = $request->all();
        $user = auth()->user();
        if ($user) {
            $review = new Review();
            $review->name = $requestData['name'];
            $review->review = $requestData['review'];
            $review->rating = $requestData['rating'];
            $review->product_id = $requestData['product_id'];
            $review->user_id = $user->id;
            if ($review->save()) {
                return response()->json(['data' => $review]);
            } else {
                return false;
            }
        } else {
            return response()->json([
                'message' => 'У вас нет доступа к данной странице'
            ], 403);
        }
    }

    public function userReviews(Request $request)
    {
        $user = auth()->user();
        $lang = request('lang');
        if ($user) {
            //$promocode = Promocode::where('user_id', $user->id)->whereNull('active')->first();
            $data['reviews'] = Review::join('products', 'products.id', 'reviews.product_id')
                ->join('translates as p_title', 'p_title.id', 'products.title')
                ->where('reviews.user_id', $user->id)
                ->select('reviews.id', 'reviews.created_at', 'reviews.review', 'reviews.rating', 'reviews.review', 'p_title.' . $lang . ' as title')
                ->get();
            return response()->json([
                'reviews' => $data
            ], 200);
        } else {
            return response()->json([
                'message' => 'У вас нет доступа к данной странице'
            ], 403);
        }
    }

    public function userOrders(Request $request)
    {
        $user = auth($this->guard)->user();
        if (isset($lang)) {
            $lang = $request->lang;
        } else {
            $lang = 'ru';
        }

        if ($user) {
            $orders = Order::where('orders.user_id', $user->id)
                ->join('callback_pay_status', 'callback_pay_status.order_id', 'orders.id')
                ->join('status_types', 'status_types.id', 'orders.status')
                ->join('translates as type_status', 'type_status.id', 'status_types.name')
                // ->select('orders.id','orders.created_at','orders.delivery', 'callback_pay_status.amount', 'type_status.'.$lang.' as type_status', 'callback_pay_status.status_type as pay_status')
                ->select('orders.id', 'orders.created_at', 'orders.delivery', 'orders.pay_status', 'orders.pay_method', 'type_status.' . $lang . ' as type_status')
                ->latest()->get();
            foreach ($orders as $item) {
                $item['product_image'] = OrderProducts::where('order_id', $item->id)
                    ->join('product_images', 'product_images.product_id', 'order_products.product_id')
                    ->select('order_products.id', 'product_images.image', 'order_products.created_at')
                    ->first();
                $item['address'] = OrderAdress::where('order_id', $item->id)->first();
                if ($item->pay_status == 1) {
                    $item['pay_status'] = CallbackPayStatus::where('callback_pay_status.order_id', $item->id)
                        ->select('callback_pay_status.status_type', 'callback_pay_status.amount')->first();
                }
            }

            return response()->json([
                'message' => 'User orders',
                'orders' => $orders
            ], 200);
        } else {
            return response()->json([
                'message' => 'У вас нет доступа к данной странице'
            ], 403);
        }
    }


    public function userUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sname' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);
        $user = \auth()->user();
        $user->update([
            'name' => $request->name,
            'sname' => $request->sname,
            'email' => $request->email,
            'phone_number' => $request->phone,
        ]);

        return response()->json([
            'data' => $user,
        ]);
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|confirmed|min:6',
        ]);
        $user = \auth()->user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password),
            ])->save();

            return response()->json([
                'message' => 'Пароль успешно обновлено'
            ], 202);
        }

        return response()->json([
            'message' => 'Неправильный пароль!'
        ], 400);
    }

    public function newPassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|confirmed|min:6',
        ]);
        $user = \auth()->user();
        $user->fill([
            'password' => Hash::make($request['new_password']),
        ])->save();

        return response()->json([
            'data' => $user,
            'message' => 'Успешно изменен!'
        ], 202);
    }

    public function postEmail()
    {
        Mail::send(['text' => 'mail.mail'], ['name', 'Web dev blog'], function ($message) {
            $message->to('kuanyshkntu@gmail.com', 'To Web dev blog')->subject('Test email');
            $message->from('kuanyshkntu@gmail.com', 'Web dev blog');
        });
    }

    public function postReset(Request $request)
    {

        $reset_password = PasswordResets::where('email', $request->email)->where('token', $request->token)->first();
        if ($reset_password) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $request->validate([
                    'password' => 'required|string|confirmed|min:6',
                ],
                    [
                        'password.confirmed' => 'Пароли не совпадают',
                        'password.required' => 'Введите пароль',
                    ]);

                $user->password = Hash::make($request->password);

                if ($user->update()) {

                    $reset_password = PasswordResets::where('email', $request->email)->get();
                    foreach ($reset_password as $item) {
                        $item->delete();
                    }

                    return response()->json([
                        'message' => 'Пароль восстановлен'
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Ошибка при восстановлении'
                    ], 500);
                }
            } else {
                return response()->json([
                    'message' => 'Пользователь с логином ' . $request->email . ' не зарегистрирован'
                ], 403);
            }
        } else {
            return response()->json([
                'message' => 'Данные для восстановления пароля не действительный'
            ], 500);
        }

    }


    public function address(Request $request)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required',
            'apartment' => 'required',
        ]);
        $user = \auth()->user();
        $address = UserAddress::create([
            'user_id' => $user->id,
            'city_id' => $request->city_id,
            'region_id' => $request->region_id,
            'address' => $request->address,
            'apartment' => $request->apartment,
        ]);

        return response()->json([
            'data' => $address,
        ], 201);
    }

    public function editAddress(Request $request)
    {
        $request->validate([
            'user_address_id' => 'required|exists:user_addresses,id',
            'region_id' => 'required|exists:regions,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required',
            'apartment' => 'required',
        ], [
            'user_address_id.exists' => 'Адрес не существует',
        ]);
        UserAddress::find($request->user_address_id)->update([
            'city_id' => $request->city_id,
            'region_id' => $request->region_id,
            'address' => $request->address,
            'apartment' => $request->apartment,
        ]);

        return response()->json([
            'message' => 'Успешно обновлено'
        ], 202);
    }

    public function deleteAddress(Request $request)
    {
        $request->validate([
            'user_address_id' => 'required|exists:user_addresses,id',
        ], [
            'user_address_id.exists' => 'Адрес не существует',
        ]);
        UserAddress::find($request->user_address_id)->delete();

        return response()->json([
            'message' => 'Успешно удалено'
        ]);
    }

}
