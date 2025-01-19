<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// - Routing trong Laravel là chức năng khai báo các đường dẫn
// để đưa người dùng đến các chức năng có trong hệ thống
// - Mỗi một route chỉ sử dụng để trỏ đến 1 chức năng cụ thể

// - Loại 1: Route nạp trực tiếp view


// - Loại 2: Sử dụng view thông qua controller (Thường dùng)

Route::resource('products', ProductController::class);
Route::resource('customers', CustomerController::class);


