<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// login: admin@demo.com
// pass: Dtnthievbn2653

// Route::get('/scr', [App\Http\Controllers\MyScriptController::class, 'run']);

Auth::routes(['reset' => false, 'register' => false]);

Route::get('/get-login', [\App\Http\Controllers\ApiController::class, 'login'])->name('get-login');

Route::middleware('role')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin');
    Route::get('/admin/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit');
    Route::post('/admin/save', [App\Http\Controllers\HomeController::class, 'save'])->name('save');
    Route::post('admin/api-update-status', [App\Http\Controllers\HomeController::class, 'apiUpdateStatus'])->name('api_update_status');
    Route::resource('admin/translate', 'App\Http\Controllers\Backend\TranslateController');
    Route::resource('admin/slider', 'App\Http\Controllers\Backend\SliderController');
    Route::resource('admin/brands', 'App\Http\Controllers\Backend\BrandsController');
    Route::get('/admin/brands/seo/{id}', [App\Http\Controllers\Backend\BrandsController::class, 'editSeo']);
    Route::post('/admin/brands/seo/{id}/update', [App\Http\Controllers\Backend\BrandsController::class, 'updateSeo']);
    Route::get('admin/brand-items/{id}', [App\Http\Controllers\Backend\BrandsController::class, 'brandItems'])->name('brand-items');
    Route::post('admin/brand-items/{id}/store', [App\Http\Controllers\Backend\BrandsController::class, 'brandItemsStore'])->name('brand-items-store');
    Route::post('admin/brand-items/{id}/update', [App\Http\Controllers\Backend\BrandsController::class, 'brandItemsUpdate'])->name('brand-items-update');
    Route::post('/admin/brand-items/{id}/delete', [App\Http\Controllers\Backend\BrandsController::class, 'brandItemsDelete'])->name('brand-items-delete');
    Route::get('admin/get-brands', [App\Http\Controllers\Backend\BrandsController::class, 'getBrand'])->name('get-brands');
//Route::resource('admin/blogs', 'App\Http\Controllers\Backend\BlogsController');
//Route::get('/admin/blogs/seo/{id}', [App\Http\Controllers\Backend\BlogsController::class, 'editSeo']);
//Route::post('/admin/blogs/seo/{id}/update', [App\Http\Controllers\Backend\BlogsController::class, 'updateSeo']);

    Route::resource('admin/category', 'App\Http\Controllers\Backend\CategoryController');
    Route::get('/admin/category/seo/{id}', [App\Http\Controllers\Backend\CategoryController::class, 'editSeo']);
    Route::post('/admin/category/seo/{id}/update', [App\Http\Controllers\Backend\CategoryController::class, 'updateSeo']);
    Route::post('/admin/category/position/{id}/update', [App\Http\Controllers\Backend\CategoryController::class, 'updatePosition']);

    Route::resource('admin/filters', 'App\Http\Controllers\Backend\FiltersController');
    Route::resource('admin/colors', 'App\Http\Controllers\Backend\ColorsController');
    Route::resource('admin/country', 'App\Http\Controllers\Backend\CountryController');
    Route::resource('admin/product', 'App\Http\Controllers\Backend\ProductsController');

    Route::get('/admin/product/seo/{id}', [App\Http\Controllers\Backend\ProductsController::class, 'editSeo']);
    Route::post('/admin/product/seo/{id}/update', [App\Http\Controllers\Backend\ProductsController::class, 'updateSeo']);
    Route::post('admin/product-delete-img/{id}', [App\Http\Controllers\Backend\ProductsController::class, 'imgDelete'])->name('img-delete');
    Route::post('/admin/product/position/{id}/update', [App\Http\Controllers\Backend\ProductsController::class, 'updatePosition']);
    Route::get('admin/get-filters', [App\Http\Controllers\Backend\FiltersController::class, 'getFilters'])->name('get-filters');
    Route::post('admin/upload-image', [App\Http\Controllers\HomeController::class, 'upload'])->name('img-upload');
    Route::get('admin/filter-items/{id}', [App\Http\Controllers\Backend\FiltersController::class, 'filterItems'])->name('filter-items');
    Route::post('admin/filter-items/{id}/store', [App\Http\Controllers\Backend\FiltersController::class, 'filterItemsStore'])->name('filter-items-store');
    Route::post('admin/filter-items/{id}/update', [App\Http\Controllers\Backend\FiltersController::class, 'filterItemsUpdate'])->name('filter-items-update');
    Route::post('admin/filter-items/{id}/delete', [App\Http\Controllers\Backend\FiltersController::class, 'filterItemsDelete'])->name('filter-items-delete');
//Route::resource('admin/sales-block', 'App\Http\Controllers\Backend\SalesBlockController');
    Route::resource('admin/contacts', 'App\Http\Controllers\Backend\ContactsController');
    Route::get('/admin/contacts/seo/{id}', [App\Http\Controllers\Backend\ContactsController::class, 'editSeo']);
    Route::post('/admin/contacts/seo/{id}/update', [App\Http\Controllers\Backend\ContactsController::class, 'updateSeo']);
    Route::resource('admin/feedback', 'App\Http\Controllers\Backend\FeedbackController');

    Route::resource('admin/orders', 'App\Http\Controllers\Backend\OrdersController');
    Route::get('admin/products-items/{id}', [App\Http\Controllers\Backend\OrdersController::class, 'productsItems'])->name('products-items');
    Route::post('admin/products-items/{id}/store', [App\Http\Controllers\Backend\OrdersController::class, 'productsItemsStore'])->name('products-items-store');
    Route::post('admin/products-items/{id}/update', [App\Http\Controllers\Backend\OrdersController::class, 'productsItemsUpdate'])->name('products-items-update');
    Route::post('admin/products-items/{id}/delete', [App\Http\Controllers\Backend\OrdersController::class, 'productsItemsDelete'])->name('products-items-delete');
    Route::resource('admin/about-us-block', 'App\Http\Controllers\Backend\AboutUsBlockController');
    Route::resource('admin/static-seo', 'App\Http\Controllers\Backend\StaticSeoController');

    Route::get('admin/import', [App\Http\Controllers\Backend\ProductsController::class, 'import'])->name('import');
    Route::post('admin/import/import-excel', [App\Http\Controllers\Backend\ImportController::class, 'importExcel'])->name('import_excel');
    Route::get('admin/export/export-excel', [App\Http\Controllers\Backend\ExportController::class, 'exportExcel'])->name('export_excel');
    Route::get('admin/export/export-excel_mail', [App\Http\Controllers\Backend\ExportController::class, 'exportExcelMail'])->name('export_excel_mail');
    Route::get('admin/export', [App\Http\Controllers\Backend\OrdersController::class, 'export'])->name('export');
    Route::post('admin/export/export-excel_order', [App\Http\Controllers\Backend\ExportController::class, 'exportExcelOrder'])->name('export_excel_order');
    Route::get('admin/import-zip', [App\Http\Controllers\Backend\ProductsController::class, 'importZip'])->name('import_zip');
    Route::post('admin/import-zip/import-img-zip', [App\Http\Controllers\Backend\ImportController::class, 'importZip'])->name('import_img_zip');

    Route::resource('admin/status-types', 'App\Http\Controllers\Backend\StatusTypesController');
    Route::resource('admin/article', 'App\Http\Controllers\Backend\ArticleController');
    Route::get('/admin/article/seo/{id}', [App\Http\Controllers\Backend\ArticleController::class, 'editSeo']);
    Route::post('/admin/article/seo/{id}/update', [App\Http\Controllers\Backend\ArticleController::class, 'updateSeo']);
    Route::resource('admin/reviews', 'App\Http\Controllers\Backend\ReviewsController');

    Route::resource('admin/region', 'App\Http\Controllers\Backend\RegionController');
    Route::get('admin/cities/{id}', [App\Http\Controllers\Backend\RegionController::class, 'cities'])->name('cities');
    Route::post('admin/cities/{id}/store', [App\Http\Controllers\Backend\RegionController::class, 'citiesStore'])->name('cities-store');
    Route::post('admin/cities/{id}/update', [App\Http\Controllers\Backend\RegionController::class, 'citiesUpdate'])->name('cities-update');
    Route::post('admin/cities/{id}/delete', [App\Http\Controllers\Backend\RegionController::class, 'citiesDelete'])->name('cities-delete');
    Route::resource('admin/size', 'App\Http\Controllers\Backend\SizeController');
    Route::get('admin/size-items/{id}', [App\Http\Controllers\Backend\SizeController::class, 'sizeItems'])->name('size-items');
    Route::post('admin/size-items/{id}/store', [App\Http\Controllers\Backend\SizeController::class, 'sizeItemsStore'])->name('size-items-store');
    Route::post('admin/size-items/{id}/update', [App\Http\Controllers\Backend\SizeController::class, 'sizeItemsUpdate'])->name('size-items-update');
    Route::post('admin/size-items/{id}/delete', [App\Http\Controllers\Backend\SizeController::class, 'sizeItemsDelete'])->name('size-items-delete');
    Route::get('admin/get-sizes', [App\Http\Controllers\Backend\SizeController::class, 'getSize'])->name('get-sizes');
    Route::resource('admin/mail', 'App\Http\Controllers\Backend\MailController');
    Route::resource('admin/promocode', 'App\Http\Controllers\Backend\PromocodeController');
    Route::post('admin/promocode/generate', [App\Http\Controllers\Backend\PromocodeController::class, 'generateCode'])->name('generateCode');
    Route::post('admin/promocode/generate-cert', [App\Http\Controllers\Backend\PromocodeController::class, 'generateCodeCert'])->name('generateCodeCert');
    Route::get('admin/admission/{id}', [App\Http\Controllers\Backend\ProductsController::class, 'admission'])->name('admissions');
    Route::post('admin/admission/{id}/store', [App\Http\Controllers\Backend\ProductsController::class, 'admissionStore'])->name('admission-store');
//Route::post('admin/admission/{id}/update',[App\Http\Controllers\Backend\ProductsController::class, 'admissionUpdate'])->name('admission-update');
    Route::post('admin/admission/{id}/delete', [App\Http\Controllers\Backend\ProductsController::class, 'admissionDelete'])->name('admission-delete');
    Route::resource('admin/click', 'App\Http\Controllers\Backend\ClickController');
    Route::resource('admin/insta', 'App\Http\Controllers\Backend\InstaController');
    Route::resource('admin/city', 'App\Http\Controllers\Backend\CityController');
    Route::resource('admin/banner', 'App\Http\Controllers\Backend\BannerController');
    Route::resource('admin/news', \App\Http\Controllers\Admin\NewsController::class);
    Route::resource('admin/addresses', \App\Http\Controllers\Admin\AddressController::class);
    Route::resource('admin/certificates', \App\Http\Controllers\Admin\CertificateController::class);
    Route::post('admin/about-delete-img/{id}', [App\Http\Controllers\Backend\AboutUsBlockController::class, 'imgDelete']);
    Route::resource('admin/deliveries', \App\Http\Controllers\Admin\DeliveryController::class);
    Route::resource('admin/users', \App\Http\Controllers\Admin\UserController::class);

    Route::resource('admin/price-types', \App\Http\Controllers\Admin\PriceTypeController::class);

    Route::get('admin/product/price-types/{id}', [\App\Http\Controllers\Backend\ProductsController::class, 'priceTypes'])->name('product-price-types');
    Route::get('admin/product/create-price-type/{id}', [\App\Http\Controllers\Backend\ProductsController::class, 'createPriceType'])->name('create-price-type');
    Route::delete('admin/product/destroy-price-type/{id}', [\App\Http\Controllers\Backend\ProductsController::class, 'destroyPriceType'])->name('destroy-price-type');
    Route::post('admin/product/store-price-type', [\App\Http\Controllers\Backend\ProductsController::class, 'storePriceType'])->name('store-price-type');

    Route::resource('admin/funds', \App\Http\Controllers\Admin\FundsController::class);
    Route::get('admin/update-import', [\App\Http\Controllers\Backend\ProductsController::class, 'updateImport'])->name('update-import');
    Route::post('admin/update-import-excel', [\App\Http\Controllers\Backend\ProductsController::class, 'updateImportExcel'])->name('update-import-excel');

    Route::get('admin/user/export-date/{id}', [\App\Http\Controllers\Admin\UserController::class, 'export'])->name('user-export-date');
    Route::post('admin/user/export-orders/{id}', [\App\Http\Controllers\Admin\UserController::class, 'exportOrder'])->name('user-export');

    Route::resource('admin/shops', \App\Http\Controllers\Admin\ShopController::class);
});
