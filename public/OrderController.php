<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show(Request $request){

        $userId=Auth::id();
        $order=Order::create([
            'user_id'=>$userId,
        ]);
        $orderId = $order->id;
        $amount=$request->amount;
        $url = 'https://tecstar.ir/callback';
        $secretKey='9A3EC03483556C73714510C507529DF70A1228C83477D1455E0511BD72C5AAB8A6715A414AA48B7C905FCEF45868BD26DA58196EF29C77C194C9F14A4B47456CC6454E9D50B388D6FC5AC91BB08B234A8060FDC85B1CEC32CA036DC907F8A4A635D9CBB9CAA31B42549B8D70B2CE5EDE8274FFB55DABFE92D76BC42D91696FAF';
        $sign=hash_hmac('sha512', $amount.'#'.$orderId.'#'.$url,$secretKey);
        $bearer='0yovdk2l6e143';

       $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://core.paystar.ir/api/pardakht/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                        "amount": "'.$amount.'",
                        "order_id": "'.$orderId.'",
                        "callback": "'.$url.'",
                        "sign": "'.$sign.'"
                    }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$bearer,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data=json_decode($response,true);

        /*DB::transaction(function () {

        });*/
        return view('dashboard.payment',['data'=>$data]);
    }
}
