<?php

namespace App\Lib;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;
    public static function curlCreate($amount,$orderId,$url,$sign,$bearer,$payStarUrl){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $payStarUrl,
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
        return $response;
    }

    public static function curlVerify($refNum,$amount,$sign,$bearer,$payStarUrl,$timOut){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $payStarUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => $timOut,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                        "ref_num": "'.$refNum.'",
                        "amount": "'.$amount.'",
                        "sign": "'.$sign.'"
                    }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$bearer,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
