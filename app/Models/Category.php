<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'Categories';
    protected $primaryKey = 'CategoryID';

    public $timestamps = false;

    public function categoryType()
    {
        return $this->belongsTo(CategoryType::class, 'CategoryTypeID');
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'RecipeCategories', 'CategoryID', 'RecipeID');
    }
}
