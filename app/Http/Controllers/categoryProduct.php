<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();


class categoryProduct extends Controller
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

    public function add_category_product(){
        $this->AuthLogin();
    	return view('admin.add_category_product');
    }
    public function all_category_product(){
        $this->AuthLogin();
    	// truy vấn show data, dùng @foreach để hiện thị data (data là kiểu array)
    	$all_category_product = DB::table('tbl_category_product')->get();
    	$manager_category_product = view('admin.all_category_product')->with('all_category_product', $all_category_product);
    	return view('admin_layout')->with('admin.all_category_product', $manager_category_product);
    }

    public function save_category_product(Request $request){
        $this->AuthLogin();
    	// insert data 
    	$data = array();
    	$data['category_name'] = $request->category_product_name;
    	$data['category_desc'] = $request->category_product_desc;
    	$data['category_status'] = $request->category_product_status;
    	DB::table('tbl_category_product')->insert($data);
    	// session
    	Session::put('message', 'Insert data successfully!');
    	// chuyển hướng
    	return Redirect::to('/add-category-product');
    }

    public function unactive_category_product($unactive_category_product){
        $this->AuthLogin();
        //update database
        DB::table('tbl_category_product')->where('category_id', $unactive_category_product)->update(['category_status' => 1]);
        return Redirect::to('all-category-product');
    }
    public function active_category_product($active_category_product){
        $this->AuthLogin();
        // update database
        DB::table('tbl_category_product')->where('category_id', $active_category_product)->update(['category_status' => 0]);
        return Redirect::to('all-category-product');
    }

    public function edit_category_product($id_category_product){
        $this->AuthLogin();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id', $id_category_product)->get();
        $manager_category_product = view('admin.edit_category_product')->with('edit_category_product', $edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product', $manager_category_product);
    }


    public function delete_category_product($id_category_product){
        $this->AuthLogin();
        // echo $id_category_product;
        DB::table('tbl_category_product')->where('category_id', $id_category_product)->delete();
        return Redirect::to('/all-category-product');
        
    }

    public function update_category_product(Request $request, $id_category_product){
        $this->AuthLogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        DB::table('tbl_category_product')->where('category_id', $id_category_product)->update($data);
        return Redirect::to('all-category-product');
    }

    // lấy sản phẩm theo id category
    public function show_category_product($category_id){
        $category = DB::table('tbl_category_product')->where('category_status', 1)->get();
        $brand = DB::table('tbl_brand')->where('brand_status', 1)->get();
        $category_by_id = DB::table('tbl_product')->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')->where('tbl_product.category_id', $category_id)->orderby('product_id', 'desc')->limit('6')->get();
        $name_cate = DB::table('tbl_category_product')->where('category_id', $category_id)->get();
        
        return view('pages.category.category_product')->with('category', $category)->with('brand', $brand)->with('category_by_id', $category_by_id)->with('category_name', $name_cate);
    }
    
}
