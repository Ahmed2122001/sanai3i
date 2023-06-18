<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $table = 'contracts';
    protected $fillable = [
        "price",
        "start_date",
        "ex_end_date",
        "customer_id",
        "worker_id"
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
}
