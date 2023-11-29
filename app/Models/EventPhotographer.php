<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class EventPhotographer extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
    ];

    public function event()
    {
        return Event::where('id', $this->event_id)->first();
    }
}
