<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'category';
    protected $fillable =
    [
        'name',
        'description',
        'image',
    ];
    use HasFactory;

    //relation with worker
    public function worker()
    {
        return $this->hasMany(Worker::class, 'category_id');
    }
}
