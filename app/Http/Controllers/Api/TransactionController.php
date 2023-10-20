<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Mpesa;

class TransactionController extends Controller
{
  
    public function confirmTransaction(Request $request)
    {
        Log::info("confirmation");
        Log::info($request -> all());

        $order = DB::table('orders') -> where('code', '=', $request -> BillRefNumber) -> first();

        $url = env('RECEIVER_API');

        $data_array = array(
            'order_id'=> $order -> id,
            'status' => 2
        );

        $data = $data_array;

        Log::info(gettype($data));

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $info = curl_getinfo($curl);
        $response = curl_exec($curl);

        $transaction = DB::table('mpesas') -> insert([
            'id' => Str::orderedUuid() -> toString(),
            'order_id' => $order -> id,
            'user_id' => $order -> user_id,
            'first_name' => $request -> FirstName,
            'middle_name' => $request -> MiddleName,
            'last_name' => $request -> LastName,
            'msisdn' => $request -> MSISDN, 
            'bill_ref_number' =>  $request -> BillRefNumber,
            'mpesa_transaction_id' =>  $request -> TransID,
            'transation_time' =>  $request -> TransTime,
            'amount' => $request -> TransAmount, 
            'created_at'=> Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

    }

    public function validateTransaction(Request $request)
    {
        Log::info("validation");
        Log::info($request -> all());
        return response() -> json(json_encode([
            'ResultCode' => 0,
            'ResultDesc' => "Accepted"
        ]));
    }

    public function registerUrl(Request $request)
    {
        $registerUrlsResponse = Mpesa::c2bRegisterUrls();
        Log::info("registerUrlsResponse");
        Log::info($registerUrlsResponse);
    }

    public function simulate(Request $request)
    {
        $simulateC2BResponse = Mpesa::simulateC2B(2, 254708374149, 'hhh');
        Log::info('simulateC2BResponse');
        Log::Info($simulateC2BResponse);
    }
}
