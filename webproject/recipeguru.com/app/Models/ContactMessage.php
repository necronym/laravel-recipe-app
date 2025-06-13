<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $table = 'ContactMessages';
    protected $primaryKey = 'messageID';
    public $timestamps = false;

    protected $fillable = ['messengerEmail', 'message'];
}
