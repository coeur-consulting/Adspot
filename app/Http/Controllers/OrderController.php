<?php

namespace App\Http\Controllers;

use auth;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\OrderResource;
use App\Notifications\PaymentSuccessful;

class OrderController extends Controller
{
    public $api_key;
    public function __construct()
    {
    $this->api_key = config('services.paystack.key');
    }
    public function generateUniqueCode()
    {
        $code = null;
        do {
            $code = random_int(10000000, 99999999);
        } while (Order::where("order_no", "=", $code)->first());

        return $code;
    }
    public function allorders()
    {
        return OrderResource::collection(Order::with('user')->latest()->paginate(20));
    }
    public function show(Order $order)
    {
        return $order->load('user','orderhistories');
    }

    public function store(Request $request)
    {

        return  DB::transaction(function () use ($request) {

            $user = auth()->user();


            $usercart = $user->cart()->get();
            $total = $usercart->map(function ($a) {
                return $a->price;
            })->reduce(function ($a, $b) {
                return $a + $b;
            });


            $order = new Order();
            $order->order_no = $this->generateUniqueCode();
            $order->status = 'pending';
            $order->total = $total;
            $order->tax = 0;


            $order->user_id = $user->id;
            $order->save();

            $mappedcart = collect($usercart)->map(function ($a) use ($order) {

                $a['order_no'] = $order->order_no;
                $a['order_id'] = $order->id;

                return $a;
            });

            $order->orderhistories()->createMany($mappedcart->toArray());

            $payment = $user->payments()->create([
                'type' => 'online',
                'reference' => $order->order_no,
                'amount' => $total,
                'status' => 'pending',
                'transactionRef' =>  $request->reference,
                'message' =>  'Awaiting payment'

            ]);

            return $this->paystackverify($request->reference);

        });
    }

    public function update(Order $order, Request $request)
    {
    }
    public function paystackverify($ref)
    {

          $response =  Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,
        ])->get(
            'https://api.paystack.co/transaction/verify/' . $ref
        );
        if ($response->json()['status'] && strtolower($response->json()['message']) == 'verification successful') {
               return $this->verify($ref);

        }else{
            return response([
                'status' =>false
            ]);
        }
    }

    public function verify($txn_id)
    {
        $user = auth()->user();
        $payment = Payment::where('transactionRef', $txn_id)->first();
        $payment->status = 'paid';
        $payment->message = 'successful';
        $payment->save();
        $order = Order::where('order_no', $payment->reference)->first();
        $order->status = "paid";
        $order->save();

        $data = [
            'name' => $user->name,
            'body' => 'Congratulations, your payment was successful, and your order with order no #'.$order->order_no .'is being processed'
        ];
        $user->notify(new PaymentSuccessful($data));

        return  [
              'status' =>true,
            'order' => $order,
            'payment' => $payment,

        ];
    }

    public function searchorders(Request $request)
    {
        $query = $request->query('query');

        if ($request->has('query') && $query) {

            return OrderResource::collection(Order::query()->whereLike('order_no', $query)->latest()->paginate(20));
        }
        return response()->json([
            'status' => 'success',
            'message' => 'no product found'
        ]);
    }
}
