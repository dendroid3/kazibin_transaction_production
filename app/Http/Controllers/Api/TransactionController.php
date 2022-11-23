<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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
        echo $transaction . '\r\n'.'\n';
    }
}
