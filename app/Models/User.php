<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\EventPhotographer;
use App\Models\UserEventAccess;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    //relacion uno a muchos
    public function profilePhotos(): HasMany
    {
        return $this->hasMany(Profile_photo::class);
    }


    //relacion uno a muchos
    public function numberContacts(): HasMany
    {
        return $this->hasMany(Number_contact::class);
    }

    /**
     * Get the events created by the user.
     */
    public function myEvents(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * The events that the photographer has agreed to attend.
     */
    public function photographerEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_photographers')->withTimestamps()->wherePivot('status', '=', 1)->orderByPivot('updated_at', 'desc');
    }

    /**
     *The events the guest has agreed to attend
     */
    public function guestEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'user_event_accesses')->withTimestamps();
    }

    /**
     * The events to which the user was invited as a photographer.
     */
    public function photographerInvitations(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_photographers')
            ->withPivot('status')
            ->withTimestamps()
            ->wherePivot('status', '=', 0)
            ->orderByPivot('updated_at', 'desc');
    }

    /**
     *
     */
    public function picturesWhereIAppear(): BelongsToMany
    {
        return $this->belongsToMany(Picture::class, 'guest_pictures')
            ->withTimestamps();
    }

    public function invitationAceptedPhotographer(Event $event) {
        return EventPhotographer::where('event_id', $event->id)
        ->where('user_id', $this->id)->first()->presence;
    }

    public function invitationAceptedUser(Event $event) {
        return UserEventAccess::where('event_id', $event->id)
        ->where('user_id', $this->id)->first()->presence;
    }
}
