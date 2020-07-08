<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class homeController extends Controller
{
	public function index() {
		$category = DB::table('tbl_category_product')->where('category_status', 1)->get();
		$brand = DB::table('tbl_brand')->where('brand_status', 1)->get();
		$product = DB::table('tbl_product')->where('product_status', 1)->limit(6)->get();
	    return view('pages.home')->with('category', $category)->with('brand', $brand)->with('product', $product);
	}

	// tìm kiếm sản phẩm
	public function search(Request $request){
		$keywords = $request->keywords_search;

		$category = DB::table('tbl_category_product')->where('category_status', 1)->get();
		$brand = DB::table('tbl_brand')->where('brand_status', 1)->get();
		
		$search_product = DB::table('tbl_product')->where('product_name', 'like', '%'.$keywords.'%')->get();

	    return view('pages.details_product.search')->with('category', $category)->with('brand', $brand)->with('search_product', $search_product);
	}
}
