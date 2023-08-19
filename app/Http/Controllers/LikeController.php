<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
use Inertia\Inertia;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Spot $spot)
    {
        $spot->likedBy()->attach(auth()->id());
        
        return redirect()->back();
    }

    public function destroy(Spot $spot)
    {
        $spot->likedBy()->detach(auth()->id());

        return redirect()->back();
    }

}
