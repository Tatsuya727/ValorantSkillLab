<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Character;

class CharacterController extends Controller
{
    public function index(Request $request)
    {
        $characters = Character::all();
        $mapName = $request->query('mapName');

        return Inertia::render('Characters/Index', [
            'characters' => $characters,
            'mapName' => $mapName,
        ]);
    }

}
