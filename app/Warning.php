<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    protected $table = "warnings";

    public function type()
    {
        return $this->belongsTo('App\Wtype', 'wtype_id');
    }
}
