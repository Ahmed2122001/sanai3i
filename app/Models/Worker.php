<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;
    protected $table='worker';
    protected $fillable=[
        "city_id",
        "name",
        "email",
        "password",
        "phone",
        "address",
        "image",
        "filed_work ",
        "description",
        "portifolio",
        "status",
        "role",
    ];
}
