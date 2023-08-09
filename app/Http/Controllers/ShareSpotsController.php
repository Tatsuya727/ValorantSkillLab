<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\Category;
use App\Models\Map;
use App\Models\Character;
use App\Models\Tag;
use Inertia\Inertia;

class ShareSpotsController extends Controller
{
    public function index(Request $request)
    {
        $tag = $request->query('tag');

        $spots = Spot::with(['images', 'map', 'character', 'tags'])
            ->when($tag, function ($query, $tag) {
                return $query->whereHas('tags', function ($query) use ($tag) {
                    $query->where('name', $tag);
                });
            })
            ->when($mapName, function ($query, $mapName) {
                return $query->whereHas('map', function ($query) use ($mapName) {
                    $query->where('name', $mapName);
                });
            })
            ->when($mapId, function ($query, $mapId) {
                return $query->whereHas('map', function ($query) use ($mapId) {
                    $query->where('id', $mapId);
                });
            })
            ->get();

        // ユーザーごとにカテゴリーを取得
        $categories = Category::where('user_id', auth()->id())->get();

        // 各spotにshow_urlプロパティを追加
        foreach ($spots as $spot) {
            $spot->show_url = route('spots.show', ['spot' => $spot->id]);
        }
        


        $characters = Character::all();
        $maps = Map::all();
        $tags = Tag::all();

        return Inertia::render('Spots/Index', [
            'spots' => $spots,
            'categories' => $categories,
            'characters' => $characters,
            'maps' => $maps,
            'tags' => $tags,
        ]);
    }
}
