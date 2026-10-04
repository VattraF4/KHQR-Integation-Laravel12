<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;



class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $id = $request->input('product_id');
        $product = Product::findOrFail($id);
        // 15 minutes validity from now (Bakong typically accepts 5 to 60 minutes)
        // Most Bakong KHQR PHP wrappers expect Unix epoch timestamp (seconds or milliseconds)
        $expiresAt = time() + (15 * 60);

        $merchant = new IndividualInfo(
            bakongAccountID: 'vattra_ra@bkrt',
            merchantName: 'Vattra Ra',
            merchantCity: 'Phnom Penh',
            billNumber: substr('INV' . $product->id . time(), 0, 20),
            storeLabel: 'Shop',
            currency: KHQRData::CURRENCY_USD,
            amount: number_format($product->price, 2, '.', ''),
            expirationTimestamp: (time() + 900) * 1000
        );


        $qrResponse = BakongKHQR::generateIndividual($merchant);


        return view('products.checkout', [
            'product' => $product,
            'qr' => data_get($qrResponse, 'data.qr'),
            'md5' => data_get($qrResponse, 'data.md5'),
        ]);
    }

    public function verifyForm()
    {
        return view('products.verify');
    }

    public function verifyTransaction(Request $request)
    {
        $request->validate([
            'md5' => 'required|string',
        ]);

        try {
            $token = env('BAKONG_TOKEN');

            if (!$token) {
                \Log::error('BAKONG_TOKEN is missing in .env');
                return response()->json([
                    'responseCode' => 1,
                    'message' => 'Bakong Token is missing',
                ]);
            }

            $bakong = new BakongKHQR($token);
            $result = $bakong->checkTransactionByMD5($request->md5);

            // Check your storage/logs/laravel.log to see the real response
            \Log::info('Bakong API Result:', ['result' => $result]);

            return response()->json($result);

        } catch (\Throwable $th) {
            \Log::error('Bakong Verify Exception: ' . $th->getMessage());
            return response()->json([
                'responseCode' => 1,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function paymentResult()
    {
        return view('payments.payment-result');
    }
}
