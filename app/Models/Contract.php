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
        "status",
        "discrption",
        "Process_status",
        "payment_type",
        "worker_id"
    ];
    // update status of contract to finished
    public function updateStatustoFinished($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->Process_status = 'مكتمل';
        $contract->save();
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
}
