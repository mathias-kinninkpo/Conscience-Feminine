<?php

// app/Models/Announcement.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'description', 'published_at', 'image', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
