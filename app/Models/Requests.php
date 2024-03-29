<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;
    protected $table = 'request';
    protected $fillable = [
        'description',
        'customer_id',
        'worker_id',
    ];
    //relation with worker
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
}
