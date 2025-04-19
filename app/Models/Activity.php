<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    // Définir les attributs assignables en masse
    protected $fillable = [
        'title',
        'description',
        'activity_date',
        'location',
        'image',
        'user_id',
    ];

    // Cast de l'attribut activity_date en instance de datetime (Carbon)
    protected $casts = [
        'activity_date' => 'datetime',
    ];

    /**
     * Relation avec le modèle User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
