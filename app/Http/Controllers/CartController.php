<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

class CartController extends Controller
{
    public function save_cart(Request $request){
    	$product_id = $request->product_id;
    	$qty = $request->qty;

    	$product_info = DB::table('tbl_product')->where('product_id', $product_id)->first();
    	

		$data['id'] = $product_id;
		$data['qty'] = $qty;
		$data['name'] = $product_info->product_name;
		$data['price'] = $product_info->product_price;
		$data['weight'] = $product_info->product_price;
		$data['options']['image'] = $product_info->product_image;
    	Cart::add($data);
    
    	// Cart::destroy();

    	return Redirect::to('/show-cart');
    	
    }

    public function show_cart(){
    	$category = DB::table('tbl_category_product')->where('category_status', 1)->get();
		$brand = DB::table('tbl_brand')->where('brand_status', 1)->get();
    	return view('pages.cart.show_cart')->with('category', $category)->with('brand', $brand);
    }

    // delete id cart
    public function delete_to_cart($id_cart){
    	Cart::update($id_cart, 0);
    	return Redirect::to('/show-cart');	
    }

    public function update_cart(Request $request){
    	$rowId = $request->cart_id;
    	$qty = $request->cart_quantity;
    	Cart::update($rowId, $qty);
    	return Redirect::to('/show-cart');	
    }
}
