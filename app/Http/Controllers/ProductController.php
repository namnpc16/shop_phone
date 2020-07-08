<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
// use Symfony\Component\HttpFoundation\Session\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
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
    public function add_product(){
    	$this->AuthLogin();
    	$category = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
    	$brand = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();
    	return view('admin.add_product')->with('product_category', $category)->with('product_brand', $brand);
    }
    public function all_product(){
    	$this->AuthLogin();
    	// truy vấn show data kiểu inner join , dùng @foreach để hiện thị data (data là kiểu array)
    	$all_product = DB::table('tbl_product')
    	->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
    	->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
    	->orderby('tbl_product.product_id', 'desc')->get();
    	$manager_product = view('admin.all_product')->with('all_product', $all_product);
    	return view('admin_layout')->with('admin.all_product', $manager_product);
    }

    public function save_product(Request $request){
    	$this->AuthLogin();
    	// insert data 
    	$data = array();
    	$data['category_id'] = $request->product_category_id;
    	$data['brand_id'] = $request->product_brand_id;
    	$data['product_name'] = $request->product_name;
    	$data['product_desc'] = $request->product_desc;
    	$data['product_content'] = $request->product_content;
    	$data['product_price'] = $request->product_price;
    	// $data['product_image'] = $request->product_image;
    	$data['product_status'] = $request->product_status;
    	// upload ảnh
    	$get_image = $request->file('product_image');
    	// kiểm tra xem có chọn ảnh không
    	if($get_image){
    		// lấy tên ảnh
    		$get_img_name = $get_image->getClientOriginalName();
    		// cắt tên ảnh ra thành từng phần 
    		$img_name = current(explode('.', $get_img_name));
    		// gộp tên ảnh vừa cắt nối với random và phần mở rộng của ảnh
    		$new_img = $img_name.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
    		// di chuyển ảnh upload vào thư mục
    		$get_image->move('public/uploads/product', $new_img);
    		// insert vào data
    		$data['product_image'] = $new_img;
    		DB::table('tbl_product')->insert($data);
	    	// session
	    	Session::put('message', 'Insert data successfully!');
	    	// chuyển hướng
	    	return Redirect::to('/add-product');
    	}
    	$data['product_image'] = '';
    	DB::table('tbl_product')->insert($data);
    	// session
    	Session::put('message', 'Insert data successfully!');
    	// chuyển hướng
    	return Redirect::to('/add-product');
    }

    public function unactive_product($unactive_product){
    	$this->AuthLogin();
        //update database
        DB::table('tbl_product')->where('product_id', $unactive_product)->update(['product_status' => 1]);
        return Redirect::to('all-product');
    }
    public function active_product($active_product){
    	$this->AuthLogin();
        // update database
        DB::table('tbl_product')->where('product_id', $active_product)->update(['product_status' => 0]);
        return Redirect::to('all-product');
    }

    public function edit_product($id_product){
    	$this->AuthLogin();
        $edit_product = DB::table('tbl_product')->where('product_id', $id_product)->get();
        $category = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
    	$brand = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();
        $manager_product = view('admin.edit_product')
        						->with('edit_product', $edit_product)
        						->with('product_category', $category)
        						->with('product_brand',$brand);
        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }



    public function delete_product($id_product){
    	$this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $id_product)->delete();
        return Redirect::to('/all-product');
        
    }

    public function update_product(Request $request, $id_product){
    	$this->AuthLogin();
        $data = array();
    	$data['category_id'] = $request->product_category_id;
    	$data['brand_id'] = $request->product_brand_id;
    	$data['product_name'] = $request->product_name;
    	$data['product_desc'] = $request->product_desc;
    	$data['product_content'] = $request->product_content;
    	$data['product_price'] = $request->product_price;
    	$data['product_status'] = $request->product_status;
    	$get_image = $request->file('product_image');
    	if($get_image){
    		$name_image = rand(0,99).$get_image->getClientOriginalName();
    		// $get_img_name = current(explode('.', $name_image));
    		// $new_img = $get_img_name.rand(0,99).'.'.$get_image->getClientOriginalExtension();
    		$get_image->move('public/uploads/product', $name_image);
    		$data['product_image'] = $name_image;
    		DB::table('tbl_product')->where('product_id', $id_product)->update($data);
    		return Redirect::to('all-product');
    	}
    	DB::table('tbl_product')->where('product_id', $id_product)->update($data);
        return Redirect::to('all-product');
    }



    // end product pages
    public function details_product($product_id){
        $category = DB::table('tbl_category_product')->where('category_status', 1)->get();
        $brand = DB::table('tbl_brand')->where('brand_status', 1)->get();
        $details_product = DB::table('tbl_product')->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')->where('product_id', $product_id)->get();
        // lấy ra id danh mục có trong bảng tbl_product 
        foreach ($details_product as $key => $value) {
            $category_id = $value->category_id;
            // echo $category_id;
        }
        $relative_product = DB::table('tbl_product')->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_id', [$product_id])->limit(3)->get();

        
        return view('pages.details_product.details_product')->with('category', $category)->with('brand', $brand)->with('product_details', $details_product)->with('relative_product', $relative_product);
        // echo "<pre>";
        // print_r($category_id);
    }
}
