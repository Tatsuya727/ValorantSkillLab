<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->user_id = $request->user_id;
        $category->save();

        return redirect()->route('spots.index');
    }
}
