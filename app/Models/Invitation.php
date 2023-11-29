<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'email_receiver',
        'send_date',
        'status',
    ];

    /**
     * 
     */
    public function event(): BelongsTo
    {
        return $this->BelongsTo(Event::class);
    }
}
