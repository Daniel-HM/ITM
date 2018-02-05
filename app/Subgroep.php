<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subgroep extends Model
{
    protected $table = 'subgroep';

    public function groep()
    {
        return $this->belongsTo('App\Groep', 'groep_id', 'groep_id');
    }
}
