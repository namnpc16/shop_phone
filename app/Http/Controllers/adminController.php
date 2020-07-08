<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// use Session;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class adminController extends Controller
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


    public function index(){
    	return view('admin_login');
    }
    public function show_dashboard(){
        // gọi hàm bảo mật website
        $this->AuthLogin();
    	return view('admin.dashboard');
    }

    // sign in
    public function dashboard(Request $request){
    	$admin_email = $request->admin_email;
    	$admin_password = md5($request->admin_password);
    	$result = DB::table('tbl_admin')->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
    	if ($result) {
    		Session::put('admin_name', $result->admin_name);
    		Session::put('admin_id', $result->admin_id);
    		return Redirect::to('/dashboard');
    	} else {
    		Session::put('message', 'Mật khẩu hoặc tài khoản không đúng!');
    		return Redirect::to('/admin');
    	}
    }

    // logout
    public function logout(){
        $this->AuthLogin();
    	Session::put('admin_name', null);
		Session::put('admin_id', null);
    	return Redirect::to('/admin');
    }
}
