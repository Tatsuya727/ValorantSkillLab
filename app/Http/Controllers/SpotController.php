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
        $currentUser = auth()->user();
        $characters = Character::all();
        $maps = Map::all();
        $tags = Tag::all();
        
        $search = $request->query('search');
        $selectedTag = $request->query('selectedTag');
        $selectedMap = $request->query('selectedMap');
        $selectedCharacter = $request->query('selectedCharacter');
        $selectedCategory = $request->query('category');
        $liked = $request->query('liked');
        $userId = $request->query('user_id');

        // ログインしているユーザーのカテゴリーを取得
        if(auth()->check()) {
            $userCategories = auth()->user()->categories;
        } else {
            $userCategories = null;
        }

        // ユーザーごとにカテゴリーを取得
        $categories = Category::where('user_id', auth()->id())->get();
        
        // ユーザーごとのスポットと保存した他人のスポットを取得
        $spots = Spot::with(['images', 'map', 'character', 'tags' , 'categories', 'user'])
            ->searchSpot($search)
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhereHas('categories', function ($query) {
                        $query->where('user_id', auth()->id());
                    });
            })
            // liledがtrueの場合、ユーザーがいいねしたスポットのみ取得
            ->when($liked, function ($query, $liked) {
                return $query->whereHas('likedBy', function ($query) {
                    $query->where('user_id', auth()->id());
                });
            })
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
                    $query->where('categories.id', $selectedCategory['id']);
                });
            })
            ->when($userId, function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->paginate(12)
            ->appends($request->all());

        

        // 各spotにshow_urlプロパティを追加
        foreach ($spots as $spot) {
            $spot->show_url = route('spots.show', ['spot' => $spot->id]);
        }        

        return Inertia::render('Spots/Index', [
            'currentUser' => $currentUser,
            'spots' => $spots,
            'categories' => $categories,
            'search' => $search,
            'selectedTag' => $selectedTag,
            'selectedMap' => $selectedMap,
            'selectedCharacter' => $selectedCharacter,
            'selectedCategory' => $selectedCategory,
            'liked' => $liked,
            'characters' => $characters,
            'maps' => $maps,
            'tags' => $tags,
            'userCategories' => $userCategories,
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
                'is_public' => $request->is_public,
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

                // 本番環境の場合
                if (config('app.env') === 'production') { 
                    // s3に画像を保存
                    $image_path = Storage::disk('s3')->putFile('images', $image['image_path'], Str::random(20) . '.' . $image['image_path']->extension());

                    // 画像のURLを取得
                    $image_path = Storage::disk('s3')->url($image_path);
                } else {
                    // 新しい画像をランダムな名前でputFileAsを使いstorage/app/public/imagesに保存
                    $image_path = Storage::putFileAs(
                        'public/images',
                        $image['image_path'],
                        Str::random(20) . '.' . $image['image_path']->extension()
                    );

                    // $image_pathの先頭のpublicをstorageに変更
                    $image_path = str_replace('public/', '', $image_path);
                    $image_path = "/storage/" . $image_path;
                }

                
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
        $spot = Spot::with(['images', 'tags', 'user', 'categories'])->find($spot->id);

        // ログインしているユーザーのカテゴリーを取得
        if(auth()->check()) {
            $userCategories = auth()->user()->categories;
        } else {
            $userCategories = null;
        }
        
        return Inertia::render('Spots/Show', [
            'spot' => $spot,
            'userCategories' => $userCategories,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spot $spot)
    {
        $spot = Spot::with('images', 'tags', 'categories')
                ->find($spot->id);
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

        return Inertia::render('Spots/Edit', [
            'spot' => $spot,
            'maps' => $maps,
            'characters' => $characters,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpotRequest $request, Spot $spot)
    {
        // dd($request->all());
        DB::transaction(function () use ($request, $spot) {
            $spot->title = $request->title;
            $spot->description = $request->description;
            $spot->map_id = $request->map_id;
            $spot->character_id = $request->character_id;
            $spot->is_public = $request->is_public;
            $spot->save();

            // タグの保存
            if($request->tags) {
                $spot->tags()->sync($request->tags);
            }

            // カテゴリーの保存
            if ($request->categories) {
                $spot->categories()->sync($request->categories);
            }

            // 画像の保存
            foreach ($request->images as $image) {
                $existingImage = $spot->images->where('image_path', $image['image_path'])->first();
                if (!$existingImage) {
                    // 本番環境の場合
                    // if (config('app.env') === 'production') { 
                    //     // s3に画像を保存
                    //     $image_path = Storage::disk('s3')->putFile('images', $image['image_path'], Str::random(20) . '.' . $image['image_path']->extension());

                    //     // 画像のURLを取得
                    //     $image_path = Storage::disk('s3')->url($image_path);
                    // } else {
                    //     // 新しい画像をランダムな名前でputFileAsを使いstorage/app/public/imagesに保存
                    //     $image_path = Storage::putFileAs(
                    //         'public/images',
                    //         $image['image_path'],
                    //         Str::random(20) . '.' . $image['image_path']->extension()
                    //     );

                    //     // $image_pathの先頭のpublicをstorageに変更
                    //     $image_path = str_replace('public/', '', $image_path);
                    //     $image_path = "/storage/" . $image_path;
                    // }
                    // $spot->images()->create([
                    //     'spot_id' => $spot->id,
                    //     'image_path' => $image_path,
                    //     'description' => $image['description'] ?? null,
                    // ]);
                } else {
                    // 既存の画像の説明を更新
                    $existingImage->description = $image['description'] ?? null;
                    $existingImage->save();
                }
                
            }
        });

        session()->flash('message', '更新しました');

        return to_route('spots.show', ['spot' => $spot->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spot $spot)
    {
        // 自分のスポットであれば削除、他人のスポットであれば自分のカテゴリーとの関連を削除
        if ($spot->user_id === auth()->id()) {
            // タグを削除
            $spot->tags()->detach();

            // S3から関連する画像を削除
            foreach ($spot->images as $image) {
                // 画像のURLからS3のキーを取得
                $path = parse_url($image->image_path, PHP_URL_PATH);
                // S3から画像を削除
                Storage::disk('s3')->delete($path);
            }

            $spot->delete();

            session()->flash('message', '削除しました');

            return to_route('spots.index');
        } else {
            $spot->categories()->detach(auth()->id());

            session()->flash('message', 'カテゴリーから削除しました');

            return to_route('spots.index');
        }
    }

    public function togglePublic($id)
    {
        $spot = Spot::find($id);
        $spot->is_public = !$spot->is_public;
        $spot->save();

        return redirect()->route('spots.show', ['spot' => $spot->id]);
    }
}
