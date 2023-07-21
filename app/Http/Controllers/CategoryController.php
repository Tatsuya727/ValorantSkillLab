<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        Category::create([
            'name' => $request->name,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('spots.index');
    }

    public function update(Request $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('spots.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('spots.index');
    }
}
