<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Subcategory;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Categories', [
            'categories' => Category::get(['id', 'name', 'image']),
            'subcategories' => Subcategory::get(['id', 'name'])
        ]);
    }
    public function  getsubcat($id)
    {
        return Subcategory::where('category_id', $id)->get();
    }

    public function storesubcat(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);
        return Inertia::render('Admin/Categories', [
            'categories' => Category::get(['id', 'name', 'image']),
            'subcategories' => Subcategory::get(['id', 'name'])
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        Category::create([
            'name' => $request->name,
            'image' => $request->image ? $request->image : 'null'
        ]);
        return Inertia::render('Admin/Categories', [
            'categories' => Category::get(['id', 'name', 'image']),
            'subcategories' => Subcategory::get(['id', 'name'])
        ]);
    }

    public function update(Category $category, Request $request)
    {

        if ($request->has('name') && $request->filled('name')) {
            $category->name = $request->name;
        }

        if ($request->has('image') && $request->filled('image')) {
            $category->image = $request->image;
        }

        $category->save();
        return Inertia::render('Admin/Categories', [
            'categories' => Category::get(['id', 'name', 'image']),
            'subcategories' => Subcategory::get(['id', 'name'])
        ]);
    }

    public function updatesubcat($id, Request $request)
    {
        $subcat = Subcategory::find($id);

        if ($request->has('name') && $request->filled('name')) {
            $subcat->name = $request->name;
        }

        if ($request->has('category_id') && $request->filled('category_id')) {
            $subcat->category_id = $request->category_id;
        }

        $subcat->save();
        return Inertia::render('Admin/Categories', [
            'categories' => Category::get(['id', 'name', 'image']),
            'subcategories' => Subcategory::get(['id', 'name'])
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return Inertia::render('Admin/Categories', [
            'categories' => Category::get(['id', 'name', 'image']),
            'subcategories' => Subcategory::get(['id', 'name'])
        ]);
    }


    public function delsubcat( $id)
    {
        $subcat = Subcategory::find($id);
        $subcat->delete();

        return Inertia::render('Admin/Categories', [
            'categories' => Category::get(['id', 'name', 'image']),
            'subcategories' => Subcategory::get(['id', 'name'])
        ]);
    }

}
