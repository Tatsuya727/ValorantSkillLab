<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SpotCategoryController extends Controller
{
    public function store(Request $request)
    {
        $spotId = $request->input('spot_id');
        $categoryId = $request->input('category_id');

        $category = Category::find($categoryId);

        if (!$category->spots()->where('spot_id', $spotId)->exists()) {
            $category->spots()->attach($spotId);
            return Inertia::render('YourComponentName', [
                'message' => 'Spot saved to category successfully.'
            ]);
        }

        return Inertia::render('YourComponentName', [
            'message' => 'Spot is already saved in this category.'
        ]);
    }

    public function destroy(Request $request)
    {
        $spotId = $request->input('spot_id');
        $categoryId = $request->input('category_id');

        $category = Category::find($categoryId);
        $category->spots()->detach($spotId);

        return Inertia::render('YourComponentName', [
            'message' => 'Spot removed from category successfully.'
        ]);
    }
}
