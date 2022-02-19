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
            'products' => ProductResource::collect(auth()->user()->products()->with('offers')->get()),
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
            'available' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required'
        ]);
        $user  = auth()->user();

        $product =   $user->products()->create([
            'name' => $request->name,
            'description' => $request->description,
            'media' => $request->images,
            'price' => $request->price,
            'available' => $request->available,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'start' => $request->start,
            'end' => $request->end,
            'location' => $request->location,
            'type' => $request->type,
            'other' => $request->other,
            'featured' => $request->featured

        ]);

        $products = $user->products()->get([
            'name',
            'description',
            'media',
            'available',
            'location',
            'type',
            'status',
            'price',
            'end',
            'other',
            'user_id',
            'category_id',
            'subcategory_id'
        ]);
        return Inertia::render('Admin/Products', [
            'products' => $products
        ]);
    }
    public function allproducts()
    {

        return  ProductResource::collect(Product::with('offers')->inRandomOrder()->paginate(30));
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
        if ($request->has('available') && $request->filled('available')) {
            $product->available = $request->available;
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
        if ($request->has('start') && $request->filled('start')) {
            $product->start = $request->start;
        }
        if ($request->has('end') && $request->filled('end')) {
            $product->end = $request->end;
        }
        if ($request->has('category_id') && $request->filled('category_id')) {
            $product->category_id = $request->category_id;
        }
        if ($request->has('subcategory_id') && $request->filled('subcategory_id')) {
            $product->subcategory_id = $request->subcategory_id;
        }

        $product->save();
        $user  = auth()->user();
        $products = $user->products()->get([
            'name',
            'description',
            'media',
            'available',
            'location',
            'type',
            'status',
            'price',
            'end',
            'other',
            'user_id',
            'category_id',
            'subcategory_id'
        ]);
        return Inertia::render('Admin/Products', [
            'products' => $products,
            'flash' => ['message' => 'success']
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $user  = auth()->user();
        $product->delete();
        $products = ProductResource::collect($user->products()->with('offers')->get());
        return Inertia::render('Admin/Products', [
            'products' => $products,
            'flash' => ['message' => 'success']
        ]);
    }

    public function searchproducts(Request $request)
    {
        $query = $request->query('query');

        if ($request->has('query') && $query) {

            return Product::query()->with('offers')->whereLike('name', $query)->paginate(50);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'no product found'
        ]);
    }
}
