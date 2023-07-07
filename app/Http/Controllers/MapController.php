<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Map;

class MapController extends Controller
{
    public function index()
    {
        $map = Map::all();

        return Inertia::render('Maps/Index', [
            'map' => $map
        ]);
    }
}
