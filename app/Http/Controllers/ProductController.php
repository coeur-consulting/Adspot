<?php

namespace App\Http\Controllers;

use auth;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SingleProductResource;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products', [
            'products' => ProductResource::collection(Product::with('offers', 'category', 'subcategory')->latest()->paginate(30)),
            'categories' => Category::all(),
            'subcategories' => Subcategory::all(),
        ]);
    }

    public function getactiveproduct()
    {
        return Inertia::render('Admin/Products', [
            'products' => ProductResource::collection(Product::with('offers', 'category', 'subcategory')->where('status', 1)->latest()->paginate(30)),
            'categories' => Category::all(),
            'subcategories' => Subcategory::all(),
        ]);
    }


    public function store(Request $request)
    {

        $request->validate([
            // 'name' => 'required',
            // 'description' => 'required',
            // 'price' => 'required',
            // 'category_id' => 'required',


        ]);
        $duration =  Carbon::parse($request->end_time)->diffInDays(Carbon::parse($request->start_time));
        $user  = auth()->user();


        $product =   $user->products()->create([
            'name' => $request->name,
            'description' => $request->description,
            'media' => $request->media,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'location' => $request->location,
            'type' => 'negotiable',
            'featured' => $request->featured,
            'dimension' => $request->dimension,
            'duration' =>  $duration,
            'impressions' => 1,
            'duration_type' => 'flexible',
            'start_time' => Carbon::parse($request->start_time),
            'end_time' => Carbon::parse($request->end_time),
            'status' => false

        ]);

        return new ProductResource($product->load('offers', 'category', 'subcategory'));
    }
    public function allproducts()
    {

        return  ProductResource::collection(Product::with('offers', 'category', 'subcategory')->where('status', 1)->latest()->paginate(30));
    }

    public function allproductsbycategory($id)
    {
        return  ProductResource::collection(Product::where('category_id', $id)->with('offers', 'category', 'subcategory')->where('status', 1)->latest()->paginate(30));
    }


    public function miniproducts()
    {

        return  ProductResource::collection(Product::with('offers', 'category', 'subcategory')->inRandomOrder()->get()->take(10));
    }

    public function featuredproducts()
    {

        return  Product::with('offers', 'category', 'subcategory')->where('featured', 1)->where('status', 1)->inRandomOrder()->get()->take(10);
    }



    public function show(Product $product)
    {
        return new SingleProductResource($product->load('offers'));
    }

    public function update(Product $product, Request $request)
    {



        if ($request->has('name') && $request->filled('name')) {
            $product->name = $request->name;
        }
        if ($request->has('description') && $request->filled('description')) {
            $product->description = $request->description;
        }
        if ($request->has('featured') && $request->filled('featured')) {
            $product->featured = $request->featured;
        }
        if ($request->has('impressions') && $request->filled('impressions')) {
            $product->impressions = $request->impressions;
        }
        if ($request->has('dimension') && $request->filled('dimension')) {
            $product->dimension = $request->dimension;
        }
        if ($request->has('end_time') && $request->filled('end_time') &&$request->has('start_time') && $request->filled('start_time')) {
            $duration =  Carbon::parse($request->end_time)->diffInDays(Carbon::parse($request->start_time));
            $product->duration = $request->duration;
        }
        if ($request->has('media') && $request->filled('media')) {
            $product->media = $request->media;
        }
        if ($request->has('price') && $request->filled('price')) {
            $product->price = $request->price;
        }
        if ($request->has('status') && $request->filled('status')) {
            $product->status = $request->status;
        }
        if ($request->has('location') && $request->filled('location')) {
            $product->location = $request->location;
        }
        if ($request->has('type') && $request->filled('type')) {
            $product->type = $request->type;
        }

        if ($request->has('category_id') && $request->filled('category_id')) {
            $product->category_id = $request->category_id;
        }
        if ($request->has('subcategory_id') && $request->filled('subcategory_id')) {
            $product->subcategory_id = $request->subcategory_id;
        }
        if ($request->has('duration_type') && $request->filled('duration_type')) {
            $product->duration_type = $request->duration_type;
        }
        if ($request->has('start_time') && $request->filled('start_time')) {
            $product->start_time = Carbon::parse($request->start_time);
        }
        if ($request->has('end_time') && $request->filled('end_time')) {
            $product->end_time = Carbon::parse($request->end_time);
            $product->space_status = 'started';
        }

        $product->save();

        return new ProductResource($product->load('offers', 'category', 'subcategory'));
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $user  = auth()->user();
        $product->delete();
        return response('ok');
    }

    public function searchproducts(Request $request)
    {
        $query = $request->query('query');

        if ($request->has('query') && $query) {

            return Product::query()->with('offers', 'category', 'subcategory')->whereLike('name', $query)->latest()->paginate(30);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'no product found'
        ]);
    }
    public function searchinventory(Request $request)
    {

        $location = $request->location;
        $subcategory_id = $request->subcategory_id;
        $start = $request->has('datevalue') && $request->filled('datevalue')? Carbon::parse($request->datevalue[0]): null;
        $end = $request->has('datevalue') && $request->filled('datevalue') ? Carbon::parse($request->datevalue[1]) : null;
        $typeFilter = $request->typeFilter;
        $durationFilter = $request->durationFilter;

        if($request->has('datevalue') && $request->filled('datevalue')){
            $product = Product::with('subcategory', 'category')
                ->where(function ($query) use ($start, $end) {
                    $query->where('start_time', '<=', $start)->where('end_time', '>=', $end);
                })
                ->where('location', 'LIKE', '%' . $location . '%')
                ->where('subcategory_id', $subcategory_id)
                ->where('status', 1)
                ->whereIn('type', $typeFilter)
                ->whereIn('duration_type', $durationFilter)


                ->paginate(30);
        }else{
            $product = Product::with('subcategory', 'category')
                ->where('location', 'LIKE', '%' . $location . '%')
                ->where('subcategory_id', $subcategory_id)
                ->where('status', 1)
                ->whereIn('type', $typeFilter)
                ->whereIn('duration_type', $durationFilter)


                ->paginate(30);
        }

        return ProductResource::collection($product);
    }

    public function handlestatus()
    {
        Product::chunk(100, function ($products) {
            foreach ($products as $product) {
                if ($product->space_status = 'started') {
                    $this->handleActive($product);
                }
            }
        });
    }
    public function handleActive($product)
    {
        $now = Carbon::now();
        $start = Carbon::parse($product->start_time);
        $end = Carbon::parse($product->end_time);
        if ($now->gte($start)) {
            $product->status = true;
            $product->save();
        }
        if ($now->gte($end)) {
            $product->status = false;
            $product->space_status = 'ended';
            $product->save();
        }
    }
}
