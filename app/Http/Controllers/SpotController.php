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
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spots = Spot::with('images')->get();

        // 各spotにshow_urlプロパティを追加
        foreach ($spots as $spot) {
            $spot->show_url = route('spots.show', ['spot' => $spot->id]);
        }

        return Inertia::render('Spots/Index', [
            'spots' => $spots,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maps = Map::all();
        $characters = Character::all();
        return Inertia::render('Spots/Create', [
            'maps' => $maps,
            'characters' => $characters,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpotRequest $request)
    {
        
        
        $spot = Spot::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'map_id' => $request->map_id,
            'character_id' => $request->character_id,
        ]);

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
                'description' => $image['description'],
            ]);
        }

        return redirect()->route('spots.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Spot $spot)
    {
        $spot = Spot::with('images')->find($spot->id);
        
        return Inertia::render('Spots/Show', [
            'spot' => $spot,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spot $spot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpotRequest $request, Spot $spot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spot $spot)
    {
        //
    }
}
