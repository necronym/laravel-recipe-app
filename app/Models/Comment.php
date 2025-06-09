<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'CommentID'; 

    public $timestamps = true;
    const CREATED_AT = 'created_at'; 
    const UPDATED_AT = 'updated_at'; 

    protected $fillable = ['UserID', 'RecipeID', 'Content'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'RecipeID');
    }
}
