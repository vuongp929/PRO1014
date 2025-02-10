<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use App\Models\Category;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('categories')) { // Kiểm tra bảng trước khi truy vấn
            $categories = Category::where('parent_id', null)->get();
            view()->share('categories', $categories);
        }
    }
}