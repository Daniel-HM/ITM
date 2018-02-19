<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groep extends Model
{
    protected $table = 'groep';

    public $timestamps = false;

    public $fillable = ['groep_id', 'omschrijving'];

    public function subgroep()
    {
        return $this->hasMany('App\Subgroep', 'subgroep_id', 'subgroep_id');
    }
}
