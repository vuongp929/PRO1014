<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Closure;

class AuthController extends Controller
{
    // Đăng nhập
    public function showFormLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập admin thành công!');
            } else {
                return redirect()->route('client.home')->with('success', 'Đăng nhập thành công!');
            }
        }

        return back()->withErrors(['error' => 'Thông tin đăng nhập không chính xác.']);
    }


    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('client.home')->with('error', 'Bạn không có quyền truy cập!');
        }

        return $next($request);
    }
    public function showFormRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Đăng xuất thành công.');
    }
}
