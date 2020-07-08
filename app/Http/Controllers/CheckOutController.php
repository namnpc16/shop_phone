<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckOutController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function check_login(){
        $category = DB::table('tbl_category_product')->where('category_status', 1)->get();
		$brand = DB::table('tbl_brand')->where('brand_status', 1)->get();
    	return view('pages.checkout.check_out_login')->with('category', $category)->with('brand', $brand);
    }

    public function add_cutomer_sigup(Request $request){
        $data = array();
        $data['customer_name'] = $request->name_sigup;
        $data['customer_email'] = $request->email_sigup;
        $data['customer_phone'] = $request->phone_sigup;
        $data['customer_pass'] = md5($request->pass_sigup);
       
        $id_customer = DB::table('tbl_customers')->insertGetId($data);
        Session::put('id_customer', $id_customer);
        Session::put('name_sigup', $request->name_sigup);
        return Redirect::to('/check-out');
    }
    public function check_out(){
        $category = DB::table('tbl_category_product')->where('category_status', 1)->get();
		$brand = DB::table('tbl_brand')->where('brand_status', 1)->get();
    	return view('pages.checkout.show_check_out')->with('category', $category)->with('brand', $brand);
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_Name;
        $data['shipping_phone'] = $request->shipping_Phone;
        $data['shipping_email'] = $request->shipping_Email;
        $data['shipping_notes'] = $request->shipping_Note;
        $data['shipping_address'] = $request->shipping_Address;
       
        $id_shopping = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('id_shipping', $id_shopping);
        return Redirect::to('/payment');
    }
    public function payment(){
        $category = DB::table('tbl_category_product')->where('category_status', 1)->get();
		$brand = DB::table('tbl_brand')->where('brand_status', 1)->get();
    	return view('pages.checkout.payment')->with('category', $category)->with('brand', $brand);
    }

    public function order_place(Request $request){
        // $content = Cart::content();
        // echo "<pre>";
        // print_r($content);
        // insert payment 
        $data = array();
        $data['paymet_method'] = $request->payment_option;
        $data['paymet_status'] = 'Đang chờ xử lý';
        $id_payment = DB::table('tbl_payment')->insertGetId($data);

        // insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('id_customer');
        $order_data['shipping_id'] = Session::get('id_shipping');
        $order_data['payment_id'] = $id_payment;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang chờ xử lý';
        $id_order = DB::table('tbl_order')->insertGetId($order_data);

        // insert order details
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data['order_id'] = $id_order;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            $order_d_data['product_name'] = $v_content->name;
            DB::table('tbl_order_details')->insertGetId($order_d_data);
        }

        if ($data['paymet_method'] == 2) {
            Cart::destroy();
            $category = DB::table('tbl_category_product')->where('category_status', 1)->get();
            $brand = DB::table('tbl_brand')->where('brand_status', 1)->get();
            return view('pages.checkout.handcash')->with('category', $category)->with('brand', $brand);
        } else {
            echo 'thanh toán bằng atm';
        }
        
        // return Redirect::to('/payment');
    }

    public function check_logout(){
        Session::flush();
        return Redirect::to('/check-login');
    }
    public function login_customer(Request $request){
        $email_account = $request->email_account;
        $pass_account = md5($request->pass_account);

        // echo "<pre>";
        // echo $email_account;
        $query_customer = DB::table('tbl_customers')
                            ->where('customer_email', $email_account)
                            ->where('customer_pass', $pass_account)->first();
        if ($query_customer) {
            Session::put('id_customer', $query_customer->customer_id);
            Session::put('name_customer', $query_customer->customer_name);
            return Redirect::to('/check-out');
        } else {
            return Redirect::to('/check-login');
        } 
    }

    // display order
    public function manage_order(){
        $this->AuthLogin();
    	
    	$all_order = DB::table('tbl_order')
    	->join('tbl_customers', 'tbl_customers.customer_id', '=', 'tbl_order.customer_id')
    	->select('tbl_order.*', 'tbl_customers.customer_name')
    	->orderby('tbl_order.order_id', 'desc')->get();
    	$manager_order = view('admin.manage_order')->with('all_order', $all_order);
    	return view('admin_layout')->with('admin.manage_order', $manager_order);
    }
    // view order
    public function view_order($order_id){
        $this->AuthLogin();
    	
    	$order_by_id = DB::table('tbl_order')
        ->join('tbl_customers', 'tbl_customers.customer_id', '=', 'tbl_order.customer_id')
        ->join('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
        ->join('tbl_shipping', 'tbl_shipping.shipping_id', '=', 'tbl_order.shipping_id')
        ->select('tbl_order.*', 'tbl_customers.*', 'tbl_order_details.*', 'tbl_shipping.*')->first();
        
    	$manager_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
    }
}
