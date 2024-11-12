<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    // Đăng nhập
    public function showFormLogin(){
        return view('auth.login');
    }
    
    public function login(){

    }
    // Đăng ký
    public function showFormRegister(){
        return view('auth.register');
    }
    public function register(){
        
    }
    // Đăng xuất
    public function logout(){
        
    }
}
