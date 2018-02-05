<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groep extends Model
{
    protected $table = 'groep';

    public function subgroep()
    {
        return $this->hasMany('App\Subgroep', 'subgroep_id', 'subgroep_id');
    }
}
