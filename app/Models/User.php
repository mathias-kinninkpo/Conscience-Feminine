<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
