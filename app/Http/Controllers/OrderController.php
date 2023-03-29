<?php

namespace App\Http\Controllers;

use App\Lib\Pay;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show(Request $request){
        DB::beginTransaction();
            $userId = Auth::id();
            $order = Order::create([
                'user_id' => $userId,
            ]);
            $orderId = $order->id;
            $amount = $request->amount;
            $payStarUrl = 'https://core.paystar.ir/api/pardakht/create';
            $url = 'http://127.0.0.1:8000/dashboard/callback';
            $secretKey = '9A3EC03483556C73714510C507529DF70A1228C83477D1455E0511BD72C5AAB8A6715A414AA48B7C905FCEF45868BD26DA58196EF29C77C194C9F14A4B47456CC6454E9D50B388D6FC5AC91BB08B234A8060FDC85B1CEC32CA036DC907F8A4A635D9CBB9CAA31B42549B8D70B2CE5EDE8274FFB55DABFE92D76BC42D91696FAF';
            $sign = hash_hmac('sha512', $amount . '#' . $orderId . '#' . $url, $secretKey);
            $bearer = '0yovdk2l6e143';
            $response = Pay::curlCreate($amount, $orderId, $url, $sign, $bearer, $payStarUrl);
            $data = json_decode($response, true);

                 Transaction::create([
                    'order_id' => $order->id,
                    'order_num' => $data['data']['order_id'],
                    'ref_num' => $data['data']['ref_num'],
                    'payment_amount' => $data['data']['payment_amount'],
                ]);
                DB::commit();
                return view('dashboard.payment', ['data' => $data, 'user' => Auth::user()]);

    }
}
