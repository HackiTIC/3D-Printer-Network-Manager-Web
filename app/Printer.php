<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    public function warnings()
    {
        return $this->hasMany('App\Warning');
    }
}
