<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function updateOrder(Request $request)
    {
        $images = $request->input('images');

        foreach ($images as $order => $id) {
            Image::where('id', $id)->update(['order' => $order]);
        }
        
        return response()->json(['status' => 'success']);
    }
}
