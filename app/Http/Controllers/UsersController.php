<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class UsersController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        return Inertia::render('Users/Index', [
            'user' => $user,
        ]);
    }
    
    public function edit()
    {
        $user = auth()->user();

        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
