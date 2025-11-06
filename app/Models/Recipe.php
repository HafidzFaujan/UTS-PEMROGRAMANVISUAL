<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'description', 
        'ingredients', 'instructions', 'image', 
        'cooking_time', 'servings', 'likes_count'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function likes()
    {
        return $this->hasMany(RecipeLike::class);
    }
}