<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;
use App\Models\Spot;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->user()->id)->get();
        $spots = Spot::with(['images', 'map', 'character', 'tags', 'categories'])
        ->where('user_id', auth()->user()->id)->get();

        return Inertia::render('Categories/Index', [
            'categories' => $categories,
            'spots' => $spots,
        ]);
    }

    public function store(Request $request)
    {
        Category::create([
            'name' => $request->name,
            'user_id' => $request->user()->id,
        ]);

        $redirectToCreate = $request->redirect_to_create;

        if ($redirectToCreate) {
            return redirect()->route('spots.create');
        } else {
            return redirect()->route('categories.index');
        }
    }

    public function update(Request $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}
