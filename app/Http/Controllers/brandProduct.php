<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class brandProduct extends Controller
{
     // bảo mật web site, nếu không đăng nhập thì k cho truy cập vào dashboard
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

  	public function add_brand_product(){
        $this->AuthLogin();
    	return view('admin.add_brand_product');
    }
    public function all_brand_product(){
        $this->AuthLogin();
    	// truy vấn show data, dùng @foreach để hiện thị data (data là kiểu array)
    	$all_brand_product = DB::table('tbl_brand')->get();
    	$manager_brand_product = view('admin.all_brand_product')->with('all_brand_product', $all_brand_product);
    	return view('admin_layout')->with('admin.all_brand_product', $manager_brand_product);
    }

    public function save_brand_product(Request $request){
    	// insert data 
        $this->AuthLogin();
    	$data = array();
    	$data['brand_name'] = $request->brand_product_name;
    	$data['brand_desc'] = $request->brand_product_desc;
    	$data['brand_status'] = $request->brand_product_status;
    	DB::table('tbl_brand')->insert($data);
    	// session
    	Session::put('message', 'Insert data successfully!');
    	// chuyển hướng
    	return Redirect::to('/add-brand-product');
    }

    public function unactive_brand_product($unactive_brand_product){
        //update database
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id', $unactive_brand_product)->update(['brand_status' => 1]);
        return Redirect::to('all-brand-product');
    }
    public function active_brand_product($active_brand_product){
        // update database
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id', $active_brand_product)->update(['brand_status' => 0]);
        return Redirect::to('all-brand-product');
    }

    public function edit_brand_product($id_brand_product){
        $this->AuthLogin();
        $edit_brand_product = DB::table('tbl_brand')->where('brand_id', $id_brand_product)->get();
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product', $edit_brand_product);
        return view('admin_layout')->with('admin.edit_brand_product', $manager_brand_product);
    }


    public function delete_brand_product($id_brand_product){
        $this->AuthLogin();
        // echo $id_category_product;
        DB::table('tbl_brand')->where('brand_id', $id_brand_product)->delete();
        return Redirect::to('/all-brand-product');
        
    }

    public function update_brand_product(Request $request, $id_brand_product){
        $this->AuthLogin();
        $data = array();
        $data['brand_name'] = $request->brand_product_name;
        $data['brand_desc'] = $request->brand_product_desc;
        DB::table('tbl_brand')->where('brand_id', $id_brand_product)->update($data);
        return Redirect::to('all-brand-product');
    }

    // lấy sản phẩm theo id brand
    public function show_brand_product($brand_id){
        $category = DB::table('tbl_category_product')->where('category_status', 1)->get();
        $brand = DB::table('tbl_brand')->where('brand_status', 1)->get();
        $brand_by_id = DB::table('tbl_product')->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')->where('tbl_product.brand_id', $brand_id)->orderby('product_id', 'desc')->limit('6')->get();
        $name_brand = DB::table('tbl_brand')->where('brand_id', $brand_id)->get();

        return view('pages.brand.brand_product')->with('category', $category)->with('brand', $brand)->with('brand_by_id', $brand_by_id)->with('brand_name', $name_brand);
    }
}
