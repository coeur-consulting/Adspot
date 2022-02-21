<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function getcategories(){
        return Category::all();
    }
    public function getsubcategories()
    {
        return Subcategory::all();
    }
    public function findspace(Request $request){
            return $request->all();
    }
}
