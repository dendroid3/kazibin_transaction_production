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
    public function getAccessToken()
    {
        $authorization = base64_encode(env('MPESA_CONSUMER_KEY') . ":" . env('MPESA_CONSUMER_SECRET'));
        $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $authorization]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_CAINFO, 'SandboxCertificate.cer');
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            Log::info(curl_error($ch));
        }

        curl_close($ch);
        return json_decode($response);
    }

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
        $authorization = base64_encode(env('MPESA_CONSUMER_KEY') . ":" . env('MPESA_CONSUMER_SECRET'));
        $authorization = $this -> getAccessToken() -> access_token;
        Log::info($authorization);
        $payload = [
            'ShortCode' => '4115361',
            'ResponseType' => 'Completed',
            "ConfirmationURL" => "https://f63e-197-232-141-33.ngrok-free.app/api/mobile_money/confirmation",
            "ValidationURL" => "https://f63e-197-232-141-33.ngrok-free.app/api/mobile_money/validation"
        ];

        $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/c2b/v2/registerurl');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $authorization,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        Log::info($response);

        if (curl_errno($ch)) {
            Log::info(curl_error($ch));
        }
    }

    public function simulate(Request $request)
    {
        $authorization = base64_encode(env('MPESA_CONSUMER_KEY') . ":" . env('MPESA_CONSUMER_SECRET'));
        $authorization = $this -> getAccessToken() -> access_token;
        $payload = [
            'ShortCode' => '4115361',
            'CommandID' => 'CustomerPayBillOnline',
            'Amount' => 200,
            'Msisdn' => '254708374149',
            'BillRefNumber' => 'TestABC'
        ];

        $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate');

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $authorization,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        Log::info($response);

        if (curl_errno($ch)) {
            Log::info(curl_error($ch));
        }
    }
}
