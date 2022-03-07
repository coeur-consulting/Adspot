<?php

namespace App\Http\Controllers;

use App\Models\StoreOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public $user;
    public $api_key;
    public function __construct()
    {
        $this->user = auth('api')->user();
        $this->api_key = config('services.paystack.sk');
    }


    public function store($request)
    {
        $request->validate(
            [
                'name' => 'required',
                'bank_name' => 'required',
                'account_no' => 'required',
                'bank_code' => 'required'

            ]
        );

        return   DB::transaction(function () use ($request) {
            $accountverification =  $this->verifyaccountnumber($request->account_no, $request->bank_code);
            if (!$accountverification) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cannot verify account details'
                ]);
            }

            $bank_name = $request->bank_name;
            $account_no = $request->account_no;
            $bank_code = $request->bank_code;

            $accountdetail = $this->user->accountdetail()->create([
                'account_no' => $account_no,
                'bank_name' => $bank_name,
                'bank_code' => $bank_code,

            ]);
        });
    }

    public function verifyaccountnumber($account_no, $bank_code)
    {

        $verify = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,

        ])->get(
            'https://api.paystack.co/bank/resolve',
            [
                'account_number' => $account_no,
                'bank_code' => $bank_code,

            ]
        );
        return $verify->json()['status'];
    }

    public function getbanks()
    {

        $response = Http::get('https://api.paystack.co/bank?coutry=nigeria');
        return  $bankdata = $response->json()['data'];
    }
    public function getbankdetail()
    {
        return $this->user->accountdetail()->first();
    }
    public function makepayment(Request $request)
    {


        return DB::transaction(function () use ($request) {


            $email = $this->user->email;
            $amount = $request['amount'] * 100;
            $order_id = $request['order_id'];


            $body = [
                'email' => $email,
                'amount' => $amount,

            ];

            $response =  Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->api_key,
            ])->post(
                'https://api.paystack.co/transaction/initialize',
                $body
            );
            $responsedata = $response->json()['data'];

            $result =   $this->user->transactions()->create([
                'reference' => $responsedata['reference'],
                'message' => 'pending',
                'status' => 'pending',
                'trxref' =>  $responsedata['access_code'],
                'redirecturl' =>  $responsedata['authorization_url'],
                'order_id' => $order_id,
                'amount' => $amount,
                'mode' => 'paystack',
                'type' => 'online'

            ]);

            return $responsedata;
        });
    }


   
}

