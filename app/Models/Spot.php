<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Image;
use App\Models\Map;
use App\Models\Character;
use App\Models\Tag;
use App\Models\User;

class Spot extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'map_id',
        'character_id',
    ];

    public function scopeSearchSpot($query, $search)
    {
        return $query->where('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->orWhereHas('tags', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })
            // ->orWhereHas('category', function ($query) use ($search) {
            //     $query->where('name', 'LIKE', "%$search%");
            // })
            ->orWhereHas('character', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })
            ->orWhereHas('map', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })
            ->orWhereHas('images', function ($query) use ($search) {
                $query->where('description', 'LIKE', "%$search%");
            });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function map()
    {
        return $this->belongsTo(Map::class);
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function getLikesCountAttribute()
    {
        return $this->likedBy->count();
    }
}
