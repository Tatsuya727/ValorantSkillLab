<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Character;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Character::all();

        return Inertia::render('Characters/Index', [
            'characters' => $characters
        ]);
    }
}
