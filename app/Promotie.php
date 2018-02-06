<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotie extends Model
{

    protected $table = 'promotie';

    public function artikel()
    {
        return $this->belongsTo('App\Artikel', 'artikelnr', 'artikelnr');
    }
}
