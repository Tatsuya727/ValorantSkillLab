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

class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Spots/Index');
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
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'map_id' => 'required',
            'character_id' => 'required',
            'images.*.image_path' => 'required',
            'images.*.description' => 'required',
        ]);
        
        $spot = Spot::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'map_id' => $request->map_id,
            'character_id' => $request->character_id,
        ]);

        foreach ($request->images as $image) {
            $spot->images()->create([
                'image_path' => $image['image_path'],
                'description' => $image['description'],
            ]);
        }
    

        return to_route('spots.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Spot $spot)
    {
        //
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
