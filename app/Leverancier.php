<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    protected $table = 'leverancier';

    public $fillable = ['leverancier_id', 'naam'];

    public $timestamps = false;

    public function artikels()
    {
        return $this->hasMany('App\Artikel', 'leverancier_id', 'leverancier_id');
    }

    public function getAll()
    {
        return $this->orderBy('naam', 'ASC')->get();
    }
}
