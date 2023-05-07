<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'region';
    protected $fillable =
    [
        'city_name',
        'code',

    ];
    use HasFactory;
    //relation with worker
    public function worker()
    {
        return $this->hasMany(Worker::class, 'city_id');
    }
}
