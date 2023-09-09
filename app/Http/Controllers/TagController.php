<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'max:10', 'unique:tags'],
        ]);
        
        Tag::create([
            'name' => $request->name,
        ]);

        session()->flash('message', $request->name . ' を作成しました。');
        
        return redirect()->route('spots.create');
    }
}
