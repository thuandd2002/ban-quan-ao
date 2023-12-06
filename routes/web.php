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

Route::get('/', function () {
    return view('welcome');
});
Route::get('testAdmin', 'DanhMucController@view');
Route::get('index', 'AdminController@index') ->name('index');
Route::get('shop', 'AdminController@shop') ->name('shop');
Route::get('detail', 'AdminController@detailCl')->name('detail');
Route::get('contact', 'AdminController@contact')->name('contact');
Route::get('checkout', 'AdminController@checkout')->name('checkout');
Route::get('cart', 'AdminController@cart')->name('cart');

//login
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@getLogin']);
Route::post('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@postLogin']);
Route::middleware(['auth'])->group(
    function () {
        //danh muc
        Route::get('danhmuc/listdanhmuc', 'DanhMucController@loadList')->name('route_BackEnd_danh_mucs');
        Route::match(['get', 'post'], 'danhmuc/add', 'DanhMucController@add')->name('route_BackEnd_danh_mucs_Add');
        Route::get('danhmuc/detail/{id}', 'DanhMucController@detail')->name('route_BackEnd_danh_mucs_Detail');
        Route::post('/danhmuc/update/{id}', 'DanhMucController@update')
            ->name('route_BackEnd_danh_mucs_Update');
        Route::get('danhmuc/delete/{id}', 'DanhMucController@delete')->name('route_BackEnd_danh_mucs_Delete');

        // sản phẩm
        Route::get('sanpham/listsanpham', 'SanPhamController@loadList')->name('route_BackEnd_san_pham');
        Route::match(['get', 'post'], 'sanpham/add', 'SanPhamController@add')->name('route_BackEnd_san_pham_Add');
        Route::get('sanpham/detail/{id}', 'SanPhamController@detail')->name('route_BackEnd_san_pham_Detail');
        Route::post('/sanpham/update/{id}', 'SanPhamController@update')
            ->name('route_BackEnd_san_pham_Update');
        Route::get('sanpham/delete/{id}', 'SanPhamController@delete')->name('route_BackEnd_san_pham_Delete');
        //banner
        Route::get('banner/list', 'BannerController@loadList')->name('route_BackEnd_banner');
        Route::match(['get', 'post'], 'banner/add', 'BannerController@add')->name('route_BackEnd_banner_Add');
        Route::get('banner/detail/{id}', 'BannerController@detail')->name('route_BackEnd_banner_Detail');
        Route::post('/banner/update/{id}', 'BannerController@update')
            ->name('route_BackEnd_banner_Update');
        Route::get('banner/delete/{id}', 'BannerController@delete')->name('route_BackEnd_banner_Delete');
    }
);
//đăng xuẩt
Route::get('/logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@getLogout']);
// client

Route::get('add-to-cart/{id}', 'AdminController@addtocart') ->name('route_Frondten_user_addToCart');
