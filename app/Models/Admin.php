<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table='admin';
    protected $fillable=[
        "name",
        "email",
        "password",
        "image",
        "phone",
        "role",
        "address",
        "city_id"
    ];
}
