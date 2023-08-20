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
        $selectedMap = $request->query('selectedMap');
        $selectedCharacter = $request->query('selectedCharacter');

        $spots = Spot::with(['images', 'map', 'character', 'tags', 'user', 'categories'])
            ->withCount('likedBy')
            ->searchSpot($search)
            ->when($tag, function ($query, $tag) {
                return $query->whereHas('tags', function ($query) use ($tag) {
                    $query->where('name', $tag);
                });
            })
            ->when($selectedMap, function ($query, $selectedMap) {
                return $query->whereHas('map', function ($query) use ($selectedMap) {
                    $query->where('id', $selectedMap['id']);
                });
            })
            ->when($selectedCharacter, function ($query, $selectedCharacter) {
                return $query->whereHas('character', function ($query) use ($selectedCharacter) {
                    $query->where('id', $selectedCharacter['id']);
                });
            })
            ->paginate(12)
            ->appends($request->all());

        // 各spotにis_liked_by_userプロパティを追加
        foreach ($spots as $spot) {
            $spot->is_liked_by_user = $spot->likedBy->contains(auth()->id());
        }

        // 検索条件に合致する全てのspotを取得
        $allSpots = Spot::with(['images', 'map', 'character', 'tags', 'categories', 'user'])
            ->searchSpot($search)
            ->when($tag, function ($query, $tag) {
                return $query->whereHas('tags', function ($query) use ($tag) {
                    $query->where('name', $tag);
                });
            })
            ->when($selectedMap, function ($query, $selectedMap) {
                return $query->whereHas('map', function ($query) use ($selectedMap) {
                    $query->where('id', $selectedMap['id']);
                });
            })
            ->when($selectedCharacter, function ($query, $selectedCharacter) {
                return $query->whereHas('character', function ($query) use ($selectedCharacter) {
                    $query->where('id', $selectedCharacter['id']);
                });
            })
            ->get();

        // ログインしているユーザーのカテゴリーを取得
        if(auth()->check()) {
            $userCategories = auth()->user()->categories;
        } else {
            $userCategories = null;
        }
      
        // Spotの合計数
        $allSpotsCount = Spot::count();

        // $spotsの合計数
        $spotsCount = $allSpots->count();

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
            'allSpotsCount' => $allSpotsCount,
            'spotsCount' => $spotsCount,
            'userCategories' => $userCategories,
            'selectedMap' => $selectedMap,
            'selectedCharacter' => $selectedCharacter,
        ]);
    }
}
