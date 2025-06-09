<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $table = 'Ratings';

    protected $primaryKey = 'RatingID';

    public $timestamps = true;

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'UserID',
        'RecipeID',
        'Score',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'RecipeID');
    }
}
