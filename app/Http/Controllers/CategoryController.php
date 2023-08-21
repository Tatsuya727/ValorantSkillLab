<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;
use App\Models\Spot;
use App\Models\Tag;
use App\Models\Map;
use App\Models\Character;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->user()->id)->get();
        $spots = Spot::with(['images', 'map', 'character', 'tags', 'categories'])
        ->where('user_id', auth()->user()->id)->get();

        $tags = Tag::all();
        $maps = Map::all();
        $characters = Character::all();

        return Inertia::render('Categories/Index', [
            'categories' => $categories,
            'spots' => $spots,
            'tags' => $tags,
            'maps' => $maps,
            'characters' => $characters,
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

    public function destroy($id)
    {
        $category = Category::find($id);

        // そのカテゴリーと関連するすべてのスポットを取得
        $spots = $category->spots;

        foreach ($spots as $spot) {
            // スポットが他のカテゴリーと関係を持っているか確認
            if ($spot->categories->count() > 1) {
                // そのカテゴリーとの中間テーブルでのつながりのみを削除
                $spot->categories()->detach($category->id);
            } else {
                // スポットを削除
                $spot->delete();
            }
        }

        // カテゴリーを削除
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'カテゴリーを削除しました。');
    }

}
