<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Events\NewNotification;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewOfferAlert;

class CartController extends Controller
{
    public function index()
    {
        return  auth()->user()->cart()->with('products')->get();
    }
    public function addtocart(Request $request)
    {


        $request->validate([

            'product_id'  => 'required',

        ]);

        return DB::transaction(function () use ($request) {
            $product = Product::find($request->product_id);
            $user  = auth()->user();

            $status =  strtolower($product->type) == 'negotiable' ? 'pending' : 'success';
            $active =  strtolower($product->type) == 'negotiable' ? true : false;
            $reference = random_int(10000000, 99999999);

            if ($request->has('cartId') && $request->filled('cartId')) {
                $cart = Cart::find($request->cartId);
                $cart->price = intval($request->price);
                $cart->total = intval($request->price);
                $cart->duration = $request->duration;
                $cart->status = $status;
                $cart->start = $request->start;
                $cart->end = $request->end;
                $cart->dateType = $request->dateType;
                $cart->reference = $reference;
                $cart->custom_days = $request->custom_days;
                $cart->save();
            } else {
                $cart =  $user->cart()->create([
                    'quantity' => 1,
                    'price'  => $request->price,
                    'total'  => intval($request->price),
                    'product_id'  =>  $request->product_id,
                    'type' => $product->type,
                    'duration' => $request->duration,
                    'status' => $status,
                    'custom_days' => $request->days,
                    'dateType' => $request->dateType,
                    'start' => $request->start,
                    'end' => $request->end,
                    'offer_no' => $reference


                ]);
            }


            $offer =  $user->offers()->create([
                'bid_price' => $request->price,
                'duration' => $request->duration,
                'product_id' => $request->product_id,
                'cart_id' => $cart->id,
                'start' => $request->start,
                'end' => $request->end,
                'result' => $status,
                'status' => $active,
                'reference' =>  $reference,
                'custom_days' => $request->days,
                'dateType' => $request->dateType
            ]);


            //if($product->type=='negotiable'){
            //Notify admin
            $admin = User::where('is_admin', 1)->first();
            $data = [
                'body' => 'There are new offers for ' . ucfirst($product->name),
                'url' => url('') . '/offers/' . $product->id, $product,
                'read_at' => null
            ];
            $admin->notify(new NewOfferAlert($data));

            // }


            return response(['message' => 'ok']);
        });
    }
    public function addcart(Request $request)
    {

        $user  = auth::user();
        $cart = Cart::where('user_id', $user->id)->where('product_id', $request->product_id)->first();
        if (!is_null($cart)) {
            $cart->quantity =  $cart->quantity++;
            $cart->save();
        } else {
            $user->cart()->create([
                'quantity' => $request->quantity,
                'price'  => $request->price,
                'total'  => intval($request->price) * intval($request->quantity),
                'product_id'  =>  $request->product_id,

            ]);
        }
        return response('ok');
    }

    public function removecart(Cart $cart)
    {


        $cart->delete();

        return response('ok');
    }
    public function carttotal()
    {

        $user = auth()->user();
        $carttotal = $user->cart()->get()->map(function ($cart) {
            return $cart->quantity * $cart->price;
        })->reduce(function ($a, $b) {
            return $a + $b;
        });

        return response([
            'total' => $carttotal
        ], 200);
    }
    public function removefromcart(Product $product)
    {

        $product->delete();
        return response('ok');
    }


    public function destroy()
    {

        $user = auth()->user();
        $carts = $user->cart()->get();
        foreach ($carts as $cart) {
            $cart->delete();
        }
        return response('ok');
    }
}
