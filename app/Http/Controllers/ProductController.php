<?php

namespace App\Http\Controllers;

use auth;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SingleProductResource;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products', [
            'products' => ProductResource::collection(Product::with('offers','category','subcategory')->paginate(30)),
            'categories' => Category::all(),
            'subcategories' => Subcategory::all(),
        ]);
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'media' => 'required',

            'price' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'location' => 'required',
            'impressions' => 'required',
        ]);

        $user  = auth()->user();

        $product =   $user->products()->create([
            'name' => $request->name,
            'description' => $request->description,
            'media' => $request->media,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'location' => $request->location,
            'type' => $request->type,
            'featured' => $request->featured,
            'dimension' => $request->dimension,
            'duration' => $request->duration,
            'impressions' => $request->impressions

        ]);

        $products = ProductResource::collection(Product::with('offers','category','subcategory')->paginate(30));
        return Inertia::render('Admin/Products', [
            'products' => $products,
            'categories' => Category::all(),
            'subcategories' => Subcategory::all(),
        ]);
    }
    public function allproducts()
    {

        return  ProductResource::collection(Product::with('offers','category','subcategory')->inRandomOrder()->paginate(30));
    }

    public function featuredproducts()
    {

        return  Product::with('offers', 'category', 'subcategory')->where('featured', 1)->inRandomOrder()->get()->take(10);
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
        if ($request->has('duration') && $request->filled('duration')) {
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

        $product->save();
        $user  = auth()->user();
        $products = ProductResource::collection(Product::with('offers', 'category', 'subcategory')->paginate(30));
        return Inertia::render('Admin/Products', [
            'products' => $products,
            'categories' => Category::all(),
            'subcategories' => Subcategory::all(),
            'flash' => ['message' => 'success']
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $user  = auth()->user();
        $product->delete();
        $products = ProductResource::collection($user->products()->with('offers','category','subcategory')->paginate(30));
        return Inertia::render('Admin/Products', [
            'products' => $products,
            'categories' => Category::all(),
            'subcategories' => Subcategory::all(),
            'flash' => ['message' => 'success']
        ]);
    }

    public function searchproducts(Request $request)
    {
        $query = $request->query('query');

        if ($request->has('query') && $query) {

            return Product::query()->with('offers','category','subcategory')->whereLike('name', $query)->paginate(30);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'no product found'
        ]);
    }
}
