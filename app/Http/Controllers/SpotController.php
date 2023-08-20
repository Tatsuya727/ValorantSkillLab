<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpotRequest;
use App\Http\Requests\UpdateSpotRequest;
use App\Models\Spot;
use App\Models\User;
use App\Models\Map;
use App\Models\Character;
use App\Models\Category;
use App\Models\Image;
use App\Models\Tag;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $characters = Character::all();
        $maps = Map::all();
        $tags = Tag::all();
        
        $tag = $request->query('tag');
        $search = $request->query('search');
        $selectedMap = $request->query('selectedMap');
        $selectedCharacter = $request->query('selectedCharacter');
        $category = $request->query('category');

        // ユーザーごとにカテゴリーを取得
        $categories = Category::where('user_id', auth()->id())->get();
        
        // ユーザーごとのスポットを取得
        $spots = Spot::with(['images', 'map', 'character', 'tags' , 'categories'])
            ->searchSpot($search)
            ->where('user_id', auth()->id())
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
            ->when($category, function ($query, $category) {
                return $query->whereHas('categories', function ($query) use ($category) {
                    $query->where('categories.id', $category);
                });
            })
            
            ->get();

        // 各spotにshow_urlプロパティを追加
        foreach ($spots as $spot) {
            $spot->show_url = route('spots.show', ['spot' => $spot->id]);
        }

        

        return Inertia::render('Spots/Index', [
            'spots' => $spots,
            'categories' => $categories,
            'selectedMap' => $selectedMap,
            'selectedCharacter' => $selectedCharacter,
            'characters' => $characters,
            'maps' => $maps,
            'tags' => $tags,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maps = Map::all();
        $characters = Character::all();
        $categories = Category::where('user_id', auth()->id())->get();
        
        $tags = Tag::all();

        // tagにそのタグを持つspotの数を追加
        foreach ($tags as $tag) {
            $tag->spotCount = Spot::whereHas('tags', function ($query) use ($tag) {
                $query->where('name', $tag->name);
            })->count();
        }

        return Inertia::render('Spots/Create', [
            'maps' => $maps,
            'characters' => $characters,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpotRequest $request)
    {

        DB::transaction(function () use ($request) {
            $spot = Spot::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => auth()->id(),
                'map_id' => $request->map_id,
                'character_id' => $request->character_id,
            ]);

            // タグの保存
            if($request->tags) {
                foreach ($request->tags as $tagId) {
                    $spot->tags()->attach($tagId);
                }
            }

            // カテゴリーの保存
            if ($request->categories) {
                $spot->categories()->sync($request->categories);
            }
        
            foreach ($request->images as $image) {
                // 画像をランダムな名前でputFileAsを使いstorage/app/public/imagesに保存
                $image_path = Storage::putFileAs(
                    'public/images',
                    $image['image_path'],
                    Str::random(20) . '.' . $image['image_path']->extension()
                );
        
                // $image_pathの先頭のpublicをstorageに変更
                $image_path = str_replace('public/', '', $image_path);
                $image_path = "/storage/" . $image_path;
                
                $spot->images()->create([
                    'spot_id' => $spot->id,
                    'image_path' => $image_path,
                    'description' => $image['description'] ?? null,
                ]);
            }
        });

        session()->flash('message', '作成しました');
        
        return to_route('categories.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Spot $spot)
    {
        $spot = Spot::with(['images', 'tags'])->find($spot->id);

        $user = User::find($spot->user_id);
        
        return Inertia::render('Spots/Show', [
            'spot' => $spot,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spot $spot)
    {
        $spot = Spot::with('images')->find($spot->id);
        $maps = Map::all();
        $characters = Character::all();

        $spot->show_url = route('spots.show', ['spot' => $spot->id]);

        return Inertia::render('Spots/Edit', [
            'spot' => $spot,
            'maps' => $maps,
            'characters' => $characters,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpotRequest $request, Spot $spot)
    {
        
        // DB::transaction(function () use ($request, $spot) {
        //     $spot->update([
        //         'title' => $request->title,
        //         'description' => $request->description,
        //         'map_id' => $request->map_id,
        //         'character_id' => $request->character_id,
        //     ]);
    
        //     foreach ($request->images as $index => $image) {
        //         // 新しい画像があれば更新、なければ既存の画像をそのまま使う
        //         if (isset($image['image_path'])) {
        //             // 新しい画像をランダムな名前でputFileAsを使いstorage/app/public/imagesに保存
        //             $image_path = Storage::putFileAs(
        //                 'public/images',
        //                 $image['image_path'],
        //                 Str::random(20) . '.' . $image['image_path']->extension()
        //             );
    
        //             // $image_pathの先頭のpublicをstorageに変更
        //             $image_path = str_replace('public/', '', $image_path);
        //             $image_path = "/storage/" . $image_path;
    
        //             // 既存の画像があれば更新、なければ新規作成
        //             if (isset($spot->images[$index])) {
        //                 $spot->images[$index]->update([
        //                     'image_path' => $image_path,
        //                     'description' => $image['description'] ?? null,
        //                 ]);
        //             } else {
        //                 $spot->images()->create([
        //                     'spot_id' => $spot->id,
        //                     'image_path' => $image_path,
        //                     'description' => $image['description'] ?? null,
        //                 ]);
        //             }
        //         } else if (isset($spot->images[$index])) {
        //             // 画像がアップロードされていない場合でも、説明があれば更新
        //             $spot->images[$index]->update([
        //                 'description' => $image['description'] ?? null,
        //             ]);
        //         }
        //     }
        // });
    
        // return redirect()->route('spots.show', ['spot' => $spot->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spot $spot)
    {
        // タグを削除
        $spot->tags()->detach();

        $spot->delete();

        session()->flash('message', '削除しました');

        return to_route('spots.index');
    }
}
