<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'Recipes';
    protected $primaryKey = 'RecipeID';

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = ['Name', 'Instructions', 'Time', 'Image', 'UserID'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'RecipeID');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'RecipeID');
    }
}
