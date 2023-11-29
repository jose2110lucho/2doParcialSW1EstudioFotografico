<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile_photo extends Model
{
    use HasFactory;

    protected $table = 'profile_photos';

    protected $fillable = [
        'profile_photo_path',   //url de la foto de perfil
        'user_id',
        'face_id'
    ];


    //relacion uno a muchos(inversa)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
