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
// frontend
Route::get('/', 'homeController@index');
Route::get('/trang-chu', 'homeController@index');
Route::post('/tim-kiem', 'homeController@search');


// category product
Route::get('/danh-muc-san-pham/{category_id}', 'categoryProduct@show_category_product');
// brand product
Route::get('/thuong-hieu-san-pham/{brand_id}', 'brandProduct@show_brand_product');
// details product
Route::get('/liet-ke-san-pham/{product_id}', 'ProductController@details_product');



// backend
Route::get('/admin', 'adminController@index');
Route::get('/dashboard', 'adminController@show_dashboard');
Route::get('/logout', 'adminController@logout');
Route::post('/admin-dashboard', 'adminController@dashboard');

// category
Route::get('/add-category-product', 'categoryProduct@add_category_product');
Route::get('/all-category-product', 'categoryProduct@all_category_product');
Route::get('/edit-category-product/{id_category_product}', 'categoryProduct@edit_category_product');
Route::get('/delete-category-product/{id_category_product}', 'categoryProduct@delete_category_product');

Route::get('/unactive-category-product/{unactive_category_product}', 'categoryProduct@unactive_category_product');
Route::get('/active-category-product/{active_category_product}', 'categoryProduct@active_category_product');

Route::post('/save-category-product', 'categoryProduct@save_category_product');
Route::post('/update-category-product/{id_category_product}', 'categoryProduct@update_category_product');


// brand product
Route::get('/add-brand-product', 'brandProduct@add_brand_product');
Route::get('/all-brand-product', 'brandProduct@all_brand_product');
Route::get('/edit-brand-product/{id_brand_product}', 'brandProduct@edit_brand_product');
Route::get('/delete-brand-product/{id_brand_product}', 'brandProduct@delete_brand_product');

Route::get('/unactive-brand-product/{unactive_brand_product}', 'brandProduct@unactive_brand_product');
Route::get('/active-brand-product/{active_brand_product}', 'brandProduct@active_brand_product');

Route::post('/save-brand-product', 'brandProduct@save_brand_product');
Route::post('/update-brand-product/{id_brand_product}', 'brandProduct@update_brand_product');

// product
Route::get('/add-product', 'ProductController@add_product');
Route::get('/all-product', 'ProductController@all_product');
Route::get('/edit-product/{id_product}', 'ProductController@edit_product');
Route::get('/delete-product/{id_product}', 'ProductController@delete_product');

Route::get('/unactive-product/{unactive_product}', 'ProductController@unactive_product');
Route::get('/active-product/{active_product}', 'ProductController@active_product');

Route::post('/save-product', 'ProductController@save_product');
Route::post('/update-product/{id_product}', 'ProductController@update_product');

// cart
Route::post('/save-cart', 'CartController@save_cart');
Route::post('/update-cart', 'CartController@update_cart');
Route::get('/show-cart', 'CartController@show_cart');
Route::get('/delete-to-cart/{id_cart}', 'CartController@delete_to_cart');

// check login
Route::get('/check-login', 'CheckOutController@check_login');
Route::get('/check-logout', 'CheckOutController@check_logout');
Route::post('/order-place', 'CheckOutController@order_place');
Route::post('/login-customer', 'CheckOutController@login_customer');

Route::post('/add-customer-sigup', 'CheckOutController@add_cutomer_sigup');
Route::post('/save-checkout-customer', 'CheckOutController@save_checkout_customer');
Route::get('/check-out', 'CheckOutController@check_out');
Route::get('/payment', 'CheckOutController@payment');


// order
Route::get('/manage-order', 'CheckOutController@manage_order');
Route::get('/view-order/{order_id}', 'CheckOutController@view_order');