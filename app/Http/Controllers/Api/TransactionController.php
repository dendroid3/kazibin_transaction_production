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
        $transaction = DB::table('mpesas') -> insert([
            'id' => Str::orderedUuid() -> toString(),
            'first_name' => 'first_name',
            'middle_name' => 'mid_name',
            'last_name' => 'last_name',
            'msisdn' => 797727253, #floor(rand(111111111,999999999)),
            'bill_ref_number' =>  strtoupper(Str::random(3)) . '-' . strtoupper(Str::random(3)),
            'mpesa_transaction_id' =>  strtoupper(Str::random(3)) . floor(rand(10,99)) . strtoupper(Str::random(2)) . floor(rand(100,999)),
            'transation_time' =>  Carbon::now()->subMinutes(floor(rand(3,300))),
            'amount' => 5000, #floor(rand(100,1000)),
            'created_at'=> Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        // echo $transaction . '\r\n'.'\n';
    }

    public function validateTransaction(Request $request)
    {
        Log::info($request -> all());
        return response() -> json(json_encode([
            'ResultCode' => 0,
            'ResultDesc' => "Accepted"
        ]));
    }

    public function registerUrl(Request $request)
    {
        // $authorization = base64_encode(env('MPESA_CONSUMER_KEY') . ":" . env('MPESA_CONSUMER_SECRET'));
        // $authorization = $this -> getAccessToken() -> access_token;
        // Log::info($authorization);
        // $payload = [
        //     'ShortCode' => env('MPESA_PAYBILL'),
        //     'ResponseType' => 'Completed',
        //     "ConfirmationURL" => env('MPESA_CONFIRMATION_URL'),
        //     "ValidationURL" => env('MPESA_VALIDATION_URL')
        // ];

        // $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/c2b/v2/registerurl');
        // curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //     'Authorization: Bearer ' . $authorization,
        //     'Content-Type: application/json'
        // ]);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // $response = curl_exec($ch);
        // $registerUrlsResponse = Mpesa::c2bRegisterUrls();
        // Log::info($registerUrlsResponse);

        // if (curl_errno($ch)) {
        //     Log::info(curl_error($ch));
        // }
    }

    public function simulate(Request $request)
    {
        // $authorization = base64_encode(env('MPESA_CONSUMER_KEY') . ":" . env('MPESA_CONSUMER_SECRET'));
        // $authorization = $this -> getAccessToken() -> access_token;
        $payload = [
            'ShortCode' => env('MPESA_PAYBILL'),
            'CommandID' => 'CustomerPayBillOnline',
            'Amount' => 1,
            'Msisdn' => '254708374149',
            'BillRefNumber' => 'TestABC',
            'authorization' => 'cGQ2R2RBZ1lreVN0ODdUdG1XYUdvRW9RQmYwTXcyWXY6eU1aWmVaZWExUndNOEpabw==',
            'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvc2FmYXJpY29tLmNvLmtlIiwiYXVkIjoiaHR0cHM6XC9cL3NhZmFyaWNvbS5jby5rZSIsImlhdCI6MTY5NTcxOTAwMywibmJmIjoxNjk1NzE5MDAzLCJleHAiOjE2OTU3MjI2MDMsImRhdGEiOnsiRmlyc3ROYW1lIjoiRGVuaXMiLCJMYXN0TmFtZSI6Ik13YW5naSIsInVzZXJuYW1lIjoia2F6aWJpbiIsIkVtYWlsQWRkcmVzcyI6ImthemliaW42NkBnbWFpbC5jb20iLCJQaG9uZU51bWJlciI6IisyNTQgNzA1IDcxNTA5OSIsImF2YXRhciI6IiIsIkZpcnN0VGltZUxvZ2luIjpmYWxzZX19.5FZmBhcovkuy7mOrA35cxDZR1Y2cPqLD1r0ERa0-VaY'
        ];

        $ch = curl_init('https://developer.safaricom.co.ke/api/v1/APIs/API/Simulate/CustomerToBusinessSimulate');

        // curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //     'Authorization: Bearer ' . 'uMMRIPVt10blJqqJ1hRibkUAhkVC',
        //     'Content-Type: application/json'
        // ]);
        // curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        Log::info($response);

        // $simulateResponse=Mpesa::simulateC2B(100, "254708374149", "Testing");

        // Log::info('simulateResponse');
        // Log::info($simulateResponse);


        if (curl_errno($ch)) {
            Log::info(curl_error($ch));
        }
    }
}
