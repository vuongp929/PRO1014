<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Routing\Controller;

class DiscountController extends Controller
{
    public function applyDiscount(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $offer = Offer::where('code', $request->code)
                      ->where('is_active', true)
                      ->where(function($query) {
                          $query->whereNull('expires_at')
                                ->orWhere('expires_at', '>', now());
                      })
                      ->first();

        if (!$offer) {
            return back()->with('error', 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.');
        }


        session()->put('discount', $offer->discount);
        return back()->with('success', "Áp dụng mã thành công! Giảm giá {$offer->discount}%.");
    }
}
