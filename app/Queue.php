<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $table = 'queue';

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
