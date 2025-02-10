<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;

class PaymentController extends Controller
{
    private $vnp_TmnCode = "DR0L927B"; 
    private $vnp_HashSecret = "MX0H4ZNSRPSBUL8QI4LNDQLHFM3ZDD15"; 
    private $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

    /**
     * Tạo URL thanh toán VNPay và chuyển hướng
     */
    public function createQRPayment(Request $request)
    {
        $order = Order::findOrFail($request->orderId);

        // Xây dựng dữ liệu thanh toán
        $inputData = $this->buildVnpayData($order);

        ksort($inputData);
        
        
        $queryString = http_build_query($inputData);
        $hashData = http_build_query($inputData);

        // Tạo chữ ký bảo mật
        $vnpSecureHash = hash_hmac('sha512', $hashData, $this->vnp_HashSecret);
        
        // Tạo URL thanh toán
        $paymentUrl = $this->vnp_Url . "?" . $queryString . "&vnp_SecureHash=" . $vnpSecureHash;
        

        // dd([
        //     'Input Data' => $inputData,
        //     'payment url' => $paymentUrl,
        //     'Hash Data String (for Signature)' => http_build_query($inputData),
        //     'Expected SecureHash from URL' => $vnpSecureHash
        // ]);

        // dd([
        //     'Generated SecureHash' => $vnpSecureHash // Chữ ký bạn tạo
        // ]);
        
        // Chuyển hướng đến VNPay
        return redirect($paymentUrl);
    }
    /**
     * Xây dựng dữ liệu thanh toán VNPay
     */
    private function buildVnpayData($order)
    {
        return [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => intval($order->total_price * 100),
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => request()->ip(),
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => "Thanh toán đơn hàng {$order->id}",
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => route('payment.vnpay.return'),
            "vnp_TxnRef" => $order->id,
            // "vnp_BankCode" => "NCB",
        ];
    }

    private function verifyVnpaySignature($request)
    {
        $vnp_SecureHash = $request->get('vnp_SecureHash');
        $inputData = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);
        ksort($inputData);

        // Sử dụng http_build_query để tạo chuỗi hashData
        $hashData = http_build_query($inputData, '', '&');
        $generatedHash = hash_hmac('sha512', $hashData, $this->vnp_HashSecret);

        // dd('VNPay SecureHash', [
        //     'Provided' => $vnp_SecureHash,
        //     'Generated' => $generatedHash,
        //     'HashData' => $hashData
        // ]);

        return $generatedHash === $vnp_SecureHash;
    }

    
        /**
     * Xử lý thông báo thanh toán từ VNPay (IPN)
     */
    public function vnpayIpn(Request $request)
    {
        if ($this->verifyVnpaySignature($request)) {
            $orderId = $request->get('vnp_TxnRef');
            $order = Order::find($orderId);

            if ($order) {
                if ($request->get('vnp_ResponseCode') == '00') {
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                    $order->save();
                    return response()->json(['RspCode' => '00', 'Message' => 'Success']);
                } else {
                    $order->payment_status = 'unpaid';
                    $order->status = 'pending';
                    $order->save();
                    return response()->json(['RspCode' => '99', 'Message' => 'Failed']);
                }
            }
        }

        return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
    }
     /**
     * Xử lý phản hồi từ VNPay khi thanh toán thành công
     */
    public function vnpayReturn(Request $request)
    { 
        $orderId = $request->get('vnp_TxnRef');
        $order = Order::find($orderId);
        // dd([
        //             'VNPay Response' => $request->all(),
        //             'Calculated SecureHash' => $this->verifyVnpaySignature($request),
        //             'Response Code' => $request->get('vnp_ResponseCode'),
        //         ]);
        if ($this->verifyVnpaySignature($request)) {
            
            
            if ($request->get('vnp_ResponseCode') == '00') {
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                    $order->save();
                    return redirect()->route('checkout.success')->with('success', 'Giao dịch thanh toán thành công!');
                
            }
        }
        // dd([
        //     'VNPay Response' => $request->all(),
        //     'Calculated SecureHash' => $this->verifyVnpaySignature($request),
        //     'Response Code' => $request->get('vnp_ResponseCode'),
        // ]);
        
    }
    public function paymentVnpaySuccess(Request $request)
    {
        $order = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->first();
        return redirect()->route('client.orders.index', compact('order'))
            ->with('success', 'Đơn hàng của bạn đang được xử lý!');
    }
    


}
