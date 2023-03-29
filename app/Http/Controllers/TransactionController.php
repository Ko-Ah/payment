<?php

namespace App\Http\Controllers;

use App\Lib\Pay;
use App\Models\Account;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{


    public function index(){
        return view('dashboard.callback');

        /*    $data = Request::createFromGlobals()->all();
           $data =  Request::getContent();

          /*
        dd($data);*/

    }
      public function store(Request $request){

          $data= $request->all();
       /*   $data=[
              'order_id'=>'62',
              'ref_num'=>'1222',
              'transaction_id'=>'1222',
              'card_number'=>'6037997319834595',
              'tracking_code'=>'3242',
          ];*/
          DB::beginTransaction();
          $order= Order::where('id',$data['order_id'])->get();
          $account=Account::where('user_id',$order[0]->user_id)->get();
          $user=User::find($order[0]->user_id);
            //Auth
          $session= Auth::login($user);
          Auth::guard('web')->login($user);
          //$request->session()->put($session);
          $request->session()->put([
              'id'=>$user->id,
              'user'=>$session
          ]);
          dd($request->session());
          $transaction=Transaction::where('order_id',$order[0]->id)->get();
          $transactions=Transaction::find($transaction[0]->id);

          if(intval(substr($data['card_number'], 0,6))==intval(substr($account[0]->account_num, 0,6)) && intval(substr($data['card_number'], 12,16))==intval(substr($account[0]->account_num, 12,16)) ) {

                  $transactions->transaction_id= $data['transaction_id'];
                  $transactions->tracking_code=$data['tracking_code'];
                  $transactions->save();

              if($data['tracking_code'] && $data['card_number']) {

                  $orderId = $order[0]->id;
                  $sumPrices = $user->items->sum('price');
                  $amount = $sumPrices;
                  $payStarUrl = 'https://core.paystar.ir/api/pardakht/verify';
                  $timOut = 10;
                  $secretKey = '9A3EC03483556C73714510C507529DF70A1228C83477D1455E0511BD72C5AAB8A6715A414AA48B7C905FCEF45868BD26DA58196EF29C77C194C9F14A4B47456CC6454E9D50B388D6FC5AC91BB08B234A8060FDC85B1CEC32CA036DC907F8A4A635D9CBB9CAA31B42549B8D70B2CE5EDE8274FFB55DABFE92D76BC42D91696FAF';
                  $sign = hash_hmac('sha512', $amount . '#' . $transactions['ref_num'] . '#' . $data['card_number'] . '#' . $transactions['tracking_code'], $secretKey);
                  $bearer = '0yovdk2l6e143';
                  $refNum = $transactions['ref_num'];
                  $response = Pay::curlVerify($refNum, $amount, $sign, $bearer, $payStarUrl, $timOut);
                  $dataResponse = json_decode($response, true);
                  $transactions->status= $dataResponse['status'];
                  $transactions->save();
                  DB::commit();
                  $message='پرداخت باموفقیت انجام شد';
                  return view('dashboard.callback', ['message' =>$message, 'transaction' => $transactions, 'user' => $user, 'dataResponse' => $dataResponse]);

          }else{
                  $message='پرداخت ناموفق بود';
                  return view('dashboard.callback',['message'=>$message]);

              }

          }else{
              $message='پرداخت ناموفق بود. شماره کارت شما درست نمی باشد';
              return view('dashboard.callback',['message'=>$message]);
          }
        }

}
