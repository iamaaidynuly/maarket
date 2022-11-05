<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//users

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
// Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
// Route::post('/refresh', [App\Http\Controllers\AuthController::class, 'refresh'])->name('refresh');
// Route::post('/log-out', [App\Http\Controllers\AuthController::class, 'logOut'])->name('logOut');
// Route::post('/user-profile', [App\Http\Controllers\AuthController::class, 'userProfile'])->name('userProfile');
// Route::post('/user-update', [App\Http\Controllers\AuthController::class, 'userUpdate'])->name('userUpdate');
// Route::post('/password-update', [App\Http\Controllers\AuthController::class, 'passwordUpdate'])->name('passwordUpdate');
// Route::post('/user-orders', [App\Http\Controllers\AuthController::class, 'userOrders'])->name('userOrders');

//Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
//    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
//    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
//    Route::post('/refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
//    Route::post('/me', [\App\Http\Controllers\AuthController::class, 'me']);
//    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
//    Route::post('/user-update', [\App\Http\Controllers\AuthController::class, 'userUpdate']);
//    Route::post('/password-update', [App\Http\Controllers\AuthController::class, 'passwordUpdate'])->name('passwordUpdate');
//    Route::post('/user-orders', [App\Http\Controllers\AuthController::class, 'userOrders'])->name('userOrders');
//    Route::post('/user-promocode', [App\Http\Controllers\AuthController::class, 'userPromocode'])->name('userPromocode');
//    Route::post('/user-reviews', [App\Http\Controllers\AuthController::class, 'userReviews'])->name('userReviews');
//    Route::post('/review', [App\Http\Controllers\AuthController::class, 'review'])->name('review');
//});


//Route::post('/confirm-code', [App\Http\Controllers\AuthController::class, 'codeConfirm']); // проверка sms кода
//Route::post('/resend-code', [App\Http\Controllers\AuthController::class, 'resendCode']);  // переотправка кода
//Route::post('/send-sms', [App\Http\Controllers\AuthController::class, 'sendSms']);  // отправка sms


//Route::get('/all-session/{id}', [App\Http\Controllers\AuthController::class, 'allSession'])->name('allSession');

// Password reset link request routes...
//Route::get('password/email', 'App\Http\Controllers\AuthController@resetPassword');

// Password reset routes...
//Route::post('password/reset', 'App\Http\Controllers\AuthController@postReset');

//Orders

Route::post('order-placement', 'App\Http\Controllers\AuthController@orderPlacement');

//Route::get('/get-order-test', [App\Http\Controllers\Api\OrderController::class, 'createPaymentTest'])->name('get-order-test');


Route::get('/home-page', [App\Http\Controllers\Api\HomePageApiController::class, 'homePage']);
//Route::get('/home-page', [App\Http\Controllers\Api\HomePageApiController::class, 'homePage'])->name('home');
//Route::get('/get-footer', [App\Http\Controllers\Api\MainBlocksApiController::class, 'getFooter'])->name('get-footer');
Route::get('/search', [\App\Http\Controllers\Api\ProductsApiController::class, 'search'])->name('search');
Route::get('/search-page', [\App\Http\Controllers\Api\ProductsApiController::class, 'searchPage'])->name('search-page');
Route::get('/get-products', [App\Http\Controllers\Api\ProductsApiController::class, 'getProducts'])->name('get-products');
//Route::get('/get-brand-products', [App\Http\Controllers\Api\ProductsApiController::class, 'getBrandProducts'])->name('get-brand-products');
//Route::get('/get-sale', [App\Http\Controllers\Api\ProductsApiController::class, 'getSale'])->name('get-sale');
//Route::get('/get-new', [App\Http\Controllers\Api\ProductsApiController::class, 'getNew'])->name('get-new');
//Route::post('/mail', [App\Http\Controllers\Api\MainBlocksApiController::class, 'mail'])->name('mail');
Route::get('/product', [App\Http\Controllers\Api\ProductsApiController::class, 'product'])->name('product');
// Route::post('/review', [App\Http\Controllers\Api\ProductsApiController::class, 'review'])->name('review');
//Route::post('/get-order', [App\Http\Controllers\Api\OrderController::class, 'getOrder'])->name('get-order');
//Route::post('/get-order-callback', [App\Http\Controllers\Api\OrderController::class, 'createPaymentCallback'])->name('get-order-callback');
//Route::post('/order-callback-check', [App\Http\Controllers\Api\OrderController::class, 'paymentCallbackCheck'])->name('order-callback-check');
//Route::post('/order-callback-pay', [App\Http\Controllers\Api\OrderController::class, 'paymentCallbackPay'])->name('order-callback-pay');
//Route::post('/order-callback-fail', [App\Http\Controllers\Api\OrderController::class, 'paymentCallbackFail'])->name('order-callback-fail');
//Route::get('/get-region', [App\Http\Controllers\Api\OrderController::class, 'getRegion'])->name('get-region');
//Route::get('/get-city', [App\Http\Controllers\Api\OrderController::class, 'getCity'])->name('get-city');
//Route::get('/card-product', [App\Http\Controllers\Api\OrderController::class, 'cardProduct'])->name('card-product');
//Route::get('/get-pages', [App\Http\Controllers\Api\PagesApiController::class, 'getPages'])->name('get-pages');
Route::get('/get-contacts', [App\Http\Controllers\ApiController::class, 'getContacts'])->name('get-contacts');
Route::post('/feedback', [App\Http\Controllers\Api\FeedbackApiController::class, 'feedback'])->name('feedback');
//Route::post('/click', [App\Http\Controllers\Api\FeedbackApiController::class, 'click'])->name('click');
//Route::post('/admission', [App\Http\Controllers\Api\FeedbackApiController::class, 'admission'])->name('admission');
//Route::post('/order', [App\Http\Controllers\ApiController::class, 'order'])->name('order');
//Route::post('/ckech-code', [App\Http\Controllers\Api\ProductsApiController::class, 'checkCode'])->name('ckech-code');
// Route::get('/best-seller', [App\Http\Controllers\ApiController::class, 'bestSeller'])->name('best-seller');
// Route::get('/new', [App\Http\Controllers\ApiController::class, 'new'])->name('new');
// Route::get('/about', [App\Http\Controllers\ApiController::class, 'about'])->name('about');

Route::prefix('V1')->group(function () {
    Route::get('/news', [\App\Http\Controllers\ApiController::class, 'news']);
    Route::get('/news-by-id', [\App\Http\Controllers\ApiController::class, 'newsById']);
    Route::get('/cities', [\App\Http\Controllers\ApiController::class, 'cities']);
    Route::get('/addresses', [\App\Http\Controllers\ApiController::class, 'addresses']);
    Route::get('/regions', [\App\Http\Controllers\ApiController::class, 'regions']);

    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

    Route::get('/get-header', [App\Http\Controllers\Api\MainBlocksApiController::class, 'getHeader'])->name('get-header');
    Route::get('/categories', [\App\Http\Controllers\Api\MainBlocksApiController::class, 'categories']);
    Route::post('/products', [\App\Http\Controllers\Api\MainBlocksApiController::class, 'products']);
    Route::get('/product-by-id', [\App\Http\Controllers\Api\MainBlocksApiController::class, 'product']);
    Route::get('/product-by-slug', [\App\Http\Controllers\Api\MainBlocksApiController::class, 'productBySlug']);

    Route::get('/home-page', [\App\Http\Controllers\Api\HomePageApiController::class, 'page']);
    Route::get('/brands', [\App\Http\Controllers\Api\HomePageApiController::class, 'brands']);
    Route::get('/page-by-slug', [\App\Http\Controllers\Api\MainBlocksApiController::class, 'bySlug']);

    Route::get('/promocode', [\App\Http\Controllers\Api\UserController::class, 'promocode']);

    Route::get('/certificates', [\App\Http\Controllers\ApiController::class, 'certificates']);

    Route::post('/password-reset', [\App\Http\Controllers\AuthController::class, 'reset']);
    Route::post('/check-code', [\App\Http\Controllers\AuthController::class, 'checkCode']);

    Route::get('/delivery-price', [\App\Http\Controllers\ApiController::class, 'delivery']);

    Route::post('/filters', [\App\Http\Controllers\ApiController::class, 'filters']);

    Route::get('/funds', [\App\Http\Controllers\ApiController::class, 'funds']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/reset-password', [\App\Http\Controllers\AuthController::class, 'newPassword']);
        Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
        Route::post('/review', [\App\Http\Controllers\AuthController::class, 'review']);
        Route::post('/user-update', [App\Http\Controllers\AuthController::class, 'userUpdate']);
        Route::post('/password-update', [App\Http\Controllers\AuthController::class, 'passwordUpdate']);
        Route::post('/add-address', [\App\Http\Controllers\AuthController::class, 'address']);

        Route::post('/add-favourite', [\App\Http\Controllers\Api\UserController::class, 'putFavourite']);
        Route::post('/add-order', [\App\Http\Controllers\Api\UserController::class, 'order']);
        Route::post('/payment', [\App\Http\Controllers\Api\PaymentController::class, 'payment']);

        Route::get('/me', [App\Http\Controllers\AuthController::class, 'me']);
        Route::get('/orders', [\App\Http\Controllers\Api\UserController::class, 'orders']);
        Route::get('/get-favourites', [\App\Http\Controllers\Api\UserController::class, 'getFavourite']);

        Route::put('/edit-address', [\App\Http\Controllers\AuthController::class, 'editAddress']);
        Route::put('/edit-review', [\App\Http\Controllers\AuthController::class, 'editReview']);

        Route::delete('/delete-favourite', [\App\Http\Controllers\Api\UserController::class, 'deleteFavourite']);
        Route::delete('/delete-address', [\App\Http\Controllers\AuthController::class, 'deleteAddress']);
        Route::delete('/delete-review', [\App\Http\Controllers\AuthController::class, 'deleteReview']);

    });
});
