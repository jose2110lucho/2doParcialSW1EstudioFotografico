<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'name',
        'detail',
        'address',
        'key_event',
        'start_date',
        'start_time',
        'privacity',
        'user_id',
    ];

    /**
     * Get the user that owns the event.
     */
    public function planner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The photographers that were invited to the event.
     */
    public function photographers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_photographers')->withTimestamps()->wherePivot('status', '=', 1);
    }

    /**
     * The guests who agreed to attend the event.
     */
    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_event_accesses')->withTimestamps();
    }

    /**
     * The email invitations that were sent from the event.
     */
    public function guestInvitations(): HasMany
    {
        return $this->HasMany(Invitation::class)->orderBy('send_date', 'desc');
    }

    /**
     *
     */
    public function photographersInvited(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_photographers')
            ->withTimestamps()
            ->withPivot('status')
            ->wherePivot('status', '!=', 1)
            ->orderByPivot('updated_at', 'desc');
    }
}
