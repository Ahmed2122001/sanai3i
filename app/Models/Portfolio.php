<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;
    protected $table = 'portfolio';
    protected $fillable =
        [
            'work_image',
            'worker_id',
        ];
    //relation with worker
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
}
