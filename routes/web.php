<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CartController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserDashboard\UserDashboardController;
use app\Http\Controllers\UserDashboard\OrderUserController;


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

Route::get('/', function () {
    return view('shop');
});



Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'ShopController@index')->name('shop');
Route::get('/cart/checkout', 'CheckoutController@index')->name('checkout');
Route::get('/user/logout','Auth\LoginController@userLogout')->name('user.logout');
Route::get('/list', 'ProductListController@index')->name('list');

//Route::get('/product', 'ProductDetailController@getProductDetail')->name('productdetail');
Route::get('product/{slug}',['as' => 'detail.productdetail', 'uses' =>'User\ProductDetailController@getProductDetail']) 
     -> where('slug','[\w\d\-\_]+');


Route::get('cart',[CartController::class,'viewcart'])->name('cart');
//Route::get('product', ['uses' => 'ProductDetailController@getDetail', 'as' => 'detail.product_detail']);
Route::middleware(['auth'])->group(function(){
    Route::get('/userdashboard', [UserDashboardController::class,'index'])->name('dashboard');
    Route::get('ordersuser','UserDashboard\OrderUserController@vỉeworderuser')->name('orderuser');
    Route::get('view-orderuser/{id}', 'UserDashboard\OrderUserController@userview')->name('userview');
    Route::post('add-to-cart',[CartController::class,'addProduct']);
    Route::post('delete-cart-item',[CartController::class,'deleteProduct']);
    Route::post('update-cart',[CartController::class,'updateCart']);
    Route::get('/cart/checkout', 'CheckoutController@index')->name('checkout');
    Route::post('place-order',[CheckoutController::class,'placeOrder']);

    Route::get('order-info',[CheckoutController::class,'info']);
});


Route::group(['middleware'=> ['auth','isAdmin'], 'prefix' => 'admin'], function(){
    Route::get('/main','Admin\FontendController@index')->name('admin.dashboard');
    Route::resource('products', 'Admin\ProductController');
    // get index -> /products
    // get show -> /products/$id
    // get edit -> /products/edit/$id -> show form
    // PUT update -> /products/edit/$id ->after submit
    // get create -> /products/create -> show form
    // POST store -> /products -> after submit
    // DELETE destroy -> /products -> after submit
    Route::resource('categories', 'Admin\CategoryController', ['except' => ['create']]);
    Route::resource('tags', 'Admin\TagController', ['except' => ['create']]);
    
    // Route::get('users', [FrontendController::class, 'users']);
    Route::get('orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('view-order/{id}', [OrderController::class, 'view']);
    Route::put('update-order/{id}',[OrderController::class,'updateorder']);
    Route::get('order-history', [OrderController::class, 'orderhistory']);
}); 

