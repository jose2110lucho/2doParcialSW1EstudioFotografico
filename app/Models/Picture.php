<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'price',
        'event_id',
        'user_id',
    ];

    /**
     *
     */
    public function guestsWhoAppear(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'guest_pictures')
            ->withTimestamps();
    }

    /**
     *
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
