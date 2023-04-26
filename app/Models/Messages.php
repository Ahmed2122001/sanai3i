<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';

    protected $fillable = ['body', 'customer_id', 'worker_id '];
    use HasFactory;
    public function sender()
    {
        return $this->morphTo();
    }

    public function recipient()
    {
        return $this->morphTo();
    }
}
