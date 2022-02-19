<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Notifications\OfferFailed;
use App\Notifications\OfferSuccess;

class OfferController extends Controller
{
    public function alluseroffers()
    {
        $user = auth()->user();
        $offers = $user->offers();
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
    public function approveoffer(Product $product, Request $request){
        $offers  = $product->offers()->get();

        foreach($offers->chunks(1000) as $offer){
            $user = User::find($offer->user_id);
            if($offer->user_id == $request->user_id){
                $offer->result = 'success';
                $user->notify(new OfferSuccess());

            }else{
                $offer->result = 'failed';
                $user->notify(new OfferFailed());
            }

            $offer->save();

        }
        $product->status = 'ended';
        $product->save();
        return $offers;

    }
    public function declineoffer(Offer $offer)
    {

                $user = User::find($offer->user_id);
                $offer->result = 'failed';
                $user->notify(new OfferFailed());
                $offer->save();

                return $offer;
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
