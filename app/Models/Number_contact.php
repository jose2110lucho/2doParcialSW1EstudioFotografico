<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Number_contact extends Model
{
    use HasFactory;

    protected $table = 'number_contacts';

    protected $fillable = [
       'description',
       'number',
       'prefix',
       'user_id',
    ];



    //relacion uno a muchos(inversa)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
