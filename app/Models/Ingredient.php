<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'Ingredients';
    protected $primaryKey = 'IngredientID';

    public $timestamps = false;

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'RecipeIngredients', 'IngredientID', 'RecipeID');
    }
}
