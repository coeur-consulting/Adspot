<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Notifications\OfferFailed;
use Illuminate\Support\Facades\DB;
use App\Notifications\OfferSuccess;

class OfferController extends Controller
{
    public function alluseroffers()
    {
        $user = auth()->user();
        $offers = $user->offers()->latest()->get();
        return $offers;
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required | numeric',
            'bid_price' => 'required | numeric'
        ]);

        $user = auth()->user();
        $offer = $user->offers()->create($request->all());
        return $offer;
    }

    public function update(Offer $offer, Request $request)
    {
        if ($request->has('bid_price') && $request->filled('bid_price')) {
            $offer->bid_price = $request->bid_price;
        }
        if ($request->has('result') && $request->filled('result')) {
            $offer->result = $request->result;
        }
        $offer->save();
        return $offer;
    }
    public function handleoffers(Request $request)
    {

        $offer = Offer::find($request->id)->load('user', 'product');
        $offers = Offer::where('product_id', $offer->product_id)->with('user', 'product')->get();
        $product = Product::find($offer->product_id);
        $user_id = $request->user_id;


        return $request->type == 'accept' ? $this->approveoffer($offers, $request->id, $product) : $this->declineoffer($offer);
    }
    public function approveoffer($offers, $id, $product)
    {

        return  DB::transaction(function () use ($offers, $id, $product) {
            foreach ($offers as $offer) {
                $user = User::find($offer->user_id);
                if ($offer->id == $id) {
                    $offer->result = 'success';
                    $data = [
                        'name' => $user->name,
                        'body' => 'Your offer for the space, ' . ucfirst($offer->product->name) . ' with a bid of NGN' . $offer->bid_price . ' has been approved'
                    ];
                     $user->notify(new OfferSuccess($data));
                } else {
                    $data = [
                        'name' => $user->name,
                        'body' => 'Your offer for the space, ' . ucfirst($offer->product->name) . ' with a bid of NGN' . $offer->bid_price . ' has been declined',
                        'url' => 'http://localhost:3000/cart'
                    ];
                    $offer->result = 'failed';
                    $user->notify(new OfferFailed($data));
                }
                $offer->status = false;
                $offer->save();
                $cart = Cart::find($offer->cart_id);
                $cart->status = 'success';
                $cart->save();
            }
            $product->status = false;
            $product->save();
            return $offers;
        });
    }
    public function declineoffer(Offer $offer)
    {

     return  DB::transaction(function() use($offer){
            $user = User::find($offer->user_id);
            $offer->result = 'failed';
            $data = [
                'name' => $user->name,
                'body' => 'Your offer for the space, ' . ucfirst($offer->product->name) . ' with a bid of NGN' . $offer->bid_price . ' has been declined.',
                'url' => 'http://localhost:3000/cart'
            ];

            $user->notify(new OfferFailed($data));
            $offer->status = false;
            $offer->save();
            $cart = Cart::find($offer->cart_id);
            $cart->status = 'success';
            $cart->save();

            return $offer;
       });
    }

    public function destroy(Offer $offer)
    {

        $offer->delete();

        return Inertia::render('Admin/Products', [
            'offer' => $offer,
            'flash' => ['message' => 'success']
        ]);
    }
}
