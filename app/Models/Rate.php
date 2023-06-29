<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $table = 'rate';
    protected $fillable =
        [
            'quality_rate',
            'price_rate',
            'time_rate',
            'customer_id',
            'worker_id ',
        ];
    //relation with worker
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
}
