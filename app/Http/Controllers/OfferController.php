<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            $code = strtoupper($request->input('code'));
            $discount = $request->input('discount');
            $expires_at = $request->input('expires_at');
            $is_active = $request->has('is_active') ? 1 : 0;

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
            // Debug dữ liệu gửi lên
            Log::info('Request data:', $request->all()); // Bỏ dấu \

            // Validate dữ liệu
            $request->validate([
                'code' => 'required|string|unique:offers,code,' . $offer->id,
                'discount' => 'required|integer|min:1|max:100',
                'expires_at' => 'nullable|date',
            ]);

            $code = strtoupper($request->input('code'));
            $discount = $request->input('discount');
            $expires_at = $request->input('expires_at');
            $is_active = $request->has('is_active') ? 1 : 0;

            // Cập nhật mã giảm giá
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
            Log::error('Update failed: ' . $e->getMessage()); // Bỏ dấu \
            return back()->withErrors('Lỗi xảy ra khi cập nhật: ' . $e->getMessage());
        }
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('offers.index')->with('success', 'Mã khuyến mãi đã được xóa.');
    }
}
