<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Worker extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $table = 'worker';
    protected $fillable = [
        "name",
        "email",
        "password",
        "phone",
        "address",
        "city_id",
        "category_id",
        "image",
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function messages()
    {
        return $this->morphMany(Message::class, 'recipient');
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
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
}
