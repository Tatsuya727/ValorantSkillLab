<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'map_id',
        'character_id',
        'category_id',
    ];

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

    
}
