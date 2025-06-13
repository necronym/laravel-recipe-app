<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $primaryKey = 'ReportID';

    protected $fillable = [
        'ReporterID',
        'TargetType',
        'TargetID',
        'Reason',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'ReporterID');
    }

    public function recipe() {
        return $this->belongsTo(\App\Models\Recipe::class, 'RecipeID');
    }

    public function comment() {
        return $this->belongsTo(\App\Models\Comment::class, 'CommentID');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'UserID');
    }
}

