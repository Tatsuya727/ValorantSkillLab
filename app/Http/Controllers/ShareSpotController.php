<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\Category;
use App\Models\Map;
use App\Models\Character;
use App\Models\Tag;
use Inertia\Inertia;

class ShareSpotController extends Controller
{
    public function index(Request $request)
    {
        $tag = $request->query('tag');
        $search = $request->query('search');

        $spots = Spot::with(['images', 'map', 'character', 'tags'])
            ->searchSpot($search)
            ->when($tag, function ($query, $tag) {
                return $query->whereHas('tags', function ($query) use ($tag) {
                    $query->where('name', $tag);
                });
            })
            ->paginate(10);

        // ユーザーごとにカテゴリーを取得
        // $categories = Category::where('user_id', auth()->id())->get();

        // 各spotにshow_urlプロパティを追加
        foreach ($spots as $spot) {
            $spot->show_url = route('spots.show', ['spot' => $spot->id]);
        }
        


        $characters = Character::all();
        $maps = Map::all();
        $tags = Tag::all();
        $categories = Category::all();

        return Inertia::render('ShareSpots/Index', [
            'spots' => $spots,
            'categories' => $categories,
            'characters' => $characters,
            'maps' => $maps,
            'tags' => $tags,
        ]);
    }
}
