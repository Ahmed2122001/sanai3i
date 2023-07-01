<?php


namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;


class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $table = 'customer';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city_id',
        'rate',
        'image',

    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
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
    // Define the relationship with messages sent by the customer
    public function sentMessages()
    {
        return $this->morphMany(Message::class, 'sender');
    }

    // Define the relationship with messages received by the customer
//    public function receivedMessages()
//    {
//        return $this->morphMany(Message::class, 'receiver');
//    }
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')->where('receiver_type', 'customer');
    }

    public function getMostRecentMessage()
    {
        return $this->messages()->latest()->first();
    }

    public function getMessageCount()
    {
        return $this->messages()->count();
    }
    //relation with contract
    public function contract()
    {
        return $this->hasMany(contract::class, 'customer_id');
    }
    public function requests()
    {
        return $this->hasMany(Requests::class, 'customer_id');
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'city_id');
    }



}
