<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotieStaging extends Model
{
    protected $table = 'promotie_staging';

    public $fillable = [
        'artikelnr', 'naam', 'omschrijving', 'startdatum', 'einddatum', 'ean'
    ];
}
