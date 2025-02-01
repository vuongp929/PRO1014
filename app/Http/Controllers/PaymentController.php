<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\Order;


class PaymentController extends Controller
{
    protected $vnp_TmnCode = "YOUR_TMN_CODE"; // Thay bằng mã TMN của bạn
    protected $vnp_HashSecret = "YOUR_HASH_SECRET"; // Thay bằng Hash Secret từ VNPay
    protected $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

    public function createQRPayment(Request $request)
    {
        $order = Order::findOrFail($request->orderId);
        $vnp_TxnRef = $order->id;
        $vnp_OrderInfo = "Thanh toán đơn hàng #" . $order->id;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $order->total_amount * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'VNPAYQR';

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => request()->ip(),
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => route('payment.vnpay.return'),
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_BankCode" => $vnp_BankCode
        ];

        ksort($inputData);
        $query = "";
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            $hashdata .= $key . "=" . $value . "&";
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $hashdata = rtrim($hashdata, '&');
        $vnp_Url = $this->vnp_Url . "?" . $query;
        if ($this->vnp_HashSecret) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return view('payment.qr', ['paymentUrl' => $vnp_Url]);
    }


    public function vnpayReturn(Request $request)
    {
        $vnp_SecureHash = $request->get('vnp_SecureHash');
        $inputData = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);

        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= $key . '=' . $value . '&';
        }
        $hashData = rtrim($hashData, '&');

        $secureHash = hash_hmac('sha512', $hashData, $this->vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            if ($request->get('vnp_ResponseCode') == '00') {
                $orderId = $request->get('vnp_TxnRef');
                $order = Order::find($orderId);

                if ($order) {
                    $order->status = 'paid';
                    $order->save();

                    return redirect()->route('dashboard')->with('success', 'Giao dịch thanh toán thành công!');
                }
            } else {
                return redirect()->route('dashboard')->with('error', 'Giao dịch thanh toán không thành công.');
            }
        } else {
            return redirect()->route('dashboard')->with('error', 'Chữ ký không hợp lệ.');
        }
    }


}
