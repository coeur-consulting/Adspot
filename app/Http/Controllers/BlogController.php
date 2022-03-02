<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Inertia\Inertia;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Blog', [
            'blogs' => Blog::paginate(20)


        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'cover' => 'required',
            'content' => 'required'
        ]);
        return    auth()->user()->blogs()->create($request->all());
    }
    public function update(Blog $blog, Request $request)
    {

        if ($request->has('name') && $request->filled('name')) {
            $blog->name = $request->name;
        }
        if ($request->has('cover') && $request->filled('cover')) {
            $blog->cover = $request->cover;
        }
        if ($request->has('content') && $request->filled('content')) {
            $blog->content = $request->content;
        }

        $blog->save();
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response('ok');
    }
}
