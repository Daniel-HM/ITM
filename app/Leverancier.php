<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    protected $table = 'leverancier';

    public function artikels()
    {
        return $this->hasMany('App\Artikel', 'leverancier_id', 'leverancier_id');
    }
}
