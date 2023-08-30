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
        $search = $request->query('search');
        $selectedTag = $request->query('selectedTag');
        $selectedMap = $request->query('selectedMap');
        $selectedCharacter = $request->query('selectedCharacter');
        $selectedCategory = $request->query('category');

        $orderBy = $request->query('orderBy');

        $spotsQuery  = Spot::with(['images', 'map', 'character', 'tags', 'user', 'categories'])
            ->where('is_public', true)
            ->withCount('likedBy')
            ->searchSpot($search)
            ->when($selectedTag, function ($query, $selectedTag) {
                return $query->whereHas('tags', function ($query) use ($selectedTag) {
                    $query->where('name', $selectedTag);
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
            ->when($selectedCategory, function ($query, $selectedCategory) {
                return $query->whereHas('categories', function ($query) use ($selectedCategory) {
                    $query->where('categories.name', $selectedCategory['name']);
                });
            });

        switch ($orderBy) {
            case 'likes':
                $spotsQuery->orderByLikes();
                break;
            case 'created_at':
                $spotsQuery->orderByCreatedAt();
                break;
            case 'categories':
                $spotsQuery->orderByCategories();
                break;
            default:
                break;
        }
        
        $spots = $spotsQuery
        ->paginate(12)
        ->appends($request->all());


        // 各spotにis_liked_by_userプロパティを追加
        foreach ($spots as $spot) {
            $spot->is_liked_by_user = $spot->likedBy->contains(auth()->id());
        }

        // 検索条件に合致する全てのspotを取得
        $allSpots = Spot::with(['images', 'map', 'character', 'tags', 'categories', 'user'])
            ->where('is_public', true)
            ->searchSpot($search)
            ->when($selectedTag, function ($query, $selectedTag) {
                return $query->whereHas('tags', function ($query) use ($selectedTag) {
                    $query->where('name', $selectedTag);
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
            $spot->show_url = route('sharespots.show', ['spot' => $spot->id]);
        }

        $characters = Character::all();
        $maps = Map::all();
        $tags = Tag::all();
        $categories = Category::select('name')->distinct()->get();


        return Inertia::render('ShareSpots/Index', [
            'spots' => $spots,
            'categories' => $categories,
            'characters' => $characters,
            'maps' => $maps,
            'tags' => $tags,
            'allSpotsCount' => $allSpotsCount,
            'spotsCount' => $spotsCount,
            'userCategories' => $userCategories,
            'search' => $search,
            'selectedTag' => $selectedTag,
            'selectedMap' => $selectedMap,
            'selectedCharacter' => $selectedCharacter,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function show(Spot $spot)
    {
        $spot = Spot::with(['images', 'tags', 'user', 'categories'])->find($spot->id);

        $spot->is_liked_by_user = $spot->likedBy->contains(auth()->id());
        $spot->liked_by_count = $spot->likedBy->count();

        // ログインしているユーザーのカテゴリーを取得
        if(auth()->check()) {
            $userCategories = auth()->user()->categories;
        } else {
            $userCategories = null;
        }

        return Inertia::render('ShareSpots/Show', [
            'spot' => $spot,
            'userCategories' => $userCategories,
        ]);
    }
}
