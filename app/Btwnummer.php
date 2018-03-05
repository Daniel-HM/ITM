<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Btwnummer extends Model
{
    protected $table = 'btwnummer';

    public $fillable = ['name', 'vatNumber', 'address', 'countryCode'];
}
