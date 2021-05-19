<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Seller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

class LoginSetupController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        // $this->middleware('guest:admin,seller,buyer')->except(['logout']);
    }

    public function form_login() {
        return view('auth.pages.login');
    }

    public function form_register() {
        return view('auth.pages.register');
    }

    public function filter_login(Request $request) {
        // return $request->login_as;
        if ( ! in_array($request->login_as, ['admin', 'seller', 'buyer'])) return redirect()->back()->withInput()->with('error', 'What re u doin?');
        if (auth()->guard($request->login_as)->attempt($request->only('username', 'password'))) {
            if ($request->login_as == "admin") {
                return redirect()->route('home.index');
            }else if($request->login_as == "seller"){
                return redirect()->route('seller.profile');
            }else{
                return redirect()->route('buyer.profile');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Username / Password Incorrect...');
        }
    }

    public function filter_register(Request $request) {
        $request->validate(
            [
                'name' => 'required',
                'phone_number' => 'required',
                'username' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ], [],
            [
                'name' => 'Name',
                'phone_number' => 'Phone Number',
                'username' => 'Username',
                'password' => 'Password',
                'password_confirmation' => 'Confirm Password',
            ]);
        if($request->register_as == 'seller'){
            $request->validate(
                [
                    'email' => 'required|unique:sellers,email',
                ], [],
                [
                    'email' => 'Email',
                ]);
        }else{
            $request->validate(
                [
                    'email' => 'email|unique:buyers,email',
                ], [],
                [
                    'email' => 'Email',
                ]);
        }
        DB::beginTransaction();
        try {
            if($request->register_as == 'seller'){
                $data = Seller::create($request->all());
            }else{
                $data = Buyer::create($request->all());
            }
            DB::commit();
            // return $data;
            return redirect()->route('form_login')->with(['msg' => ['type' => 'success', 'msg' => "Data ".$data->nama." Added Successfully."]]);
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['msg' => ['type' => 'danger', 'msg' => "Error Occured"]]);
        }

    }

    public function logout() {
        auth()->guard('admin')->logout();
        auth()->guard('seller')->logout();
        auth()->guard('buyer')->logout();
        return redirect()->route('form_login');
    }
}
