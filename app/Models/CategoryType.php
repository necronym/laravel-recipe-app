<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    protected $table = 'CategoryTypes';
    protected $primaryKey = 'CategoryTypeID';

    public $timestamps = false;

    public function categories()
    {
        return $this->hasMany(Category::class, 'CategoryTypeID');
    }
}
