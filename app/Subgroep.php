<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subgroep extends Model
{
    protected $table = 'subgroep';

    public $timestamps = false;

    public $fillable = ['groep_id', 'subgroep_id', 'omschrijving'];

    public function groep()
    {
        return $this->belongsTo('App\Groep', 'groep_id', 'groep_id');
    }
}
