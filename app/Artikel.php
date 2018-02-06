<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{

    protected $table = 'artikel';

    public function leverancier()
    {
        return $this->belongsTo('App\Leverancier', 'leverancier_id', 'leverancier_id');
    }

    public function subgroep()
    {
        return $this->belongsTo('App\Subgroep', 'subgroep_id', 'subgroep_id');
    }

    public function promotie()
    {
        return $this->hasOne('App\Promotie', 'artikelnr', 'artikelnr');
    }

}
