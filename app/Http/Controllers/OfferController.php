<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Exception;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::all();
        return view('admins.offers.index', compact('offers'));
    }

    public function create()
    {
        return view('admins.offers.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Lấy dữ liệu từ request
            $code = strtoupper($request->input('code')); // Viết hoa mã giảm giá
            $discount = $request->input('discount');
            $expires_at = $request->input('expires_at');
            $is_active = $request->has('is_active') ? 1 : 0; // Nếu checkbox được chọn, set là 1, ngược lại là 0

            // Tạo mã giảm giá
            Offer::create([
                'code' => $code,
                'discount' => $discount,
                'expires_at' => $expires_at,
                'is_active' => $is_active,
            ]);

            DB::commit();
            
            return redirect()->route('offers.index')->with('success', 'Mã khuyến mãi đã được tạo.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors('Lỗi xảy ra: ' . $e->getMessage());
        }
    }


    public function edit(Offer $offer)
    {
        return view('admins.offers.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
{
    DB::beginTransaction();
    try {
        // Validate dữ liệu đầu vào
        $request->validate([
            'code' => 'required|string|unique:offers,code,' . $offer->id,
            'discount' => 'required|integer|min:1|max:100',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean'
        ]);

        // Lấy dữ liệu từ request
        $code = strtoupper($request->input('code')); // Viết hoa mã giảm giá
        $discount = $request->input('discount');
        $expires_at = $request->input('expires_at');
        $is_active = $request->has('is_active') ? 1 : 0;

        // Cập nhật dữ liệu mã giảm giá
        $offer->update([
            'code' => $code,
            'discount' => $discount,
            'expires_at' => $expires_at,
            'is_active' => $is_active,
        ]);

        DB::commit();

        return redirect()->route('offers.index')->with('success', 'Mã khuyến mãi đã được cập nhật.');
    } catch (Exception $e) {
        DB::rollBack();
        return back()->withErrors('Lỗi xảy ra khi cập nhật: ' . $e->getMessage());
    }
}


    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('offers.index')->with('success', 'Mã khuyến mãi đã được xóa.');
    }
}
