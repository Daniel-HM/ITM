<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotie extends Model
{

    /**
     * @var string
     */
    protected $table = 'promotie';

    public $timestamps = false;

    public $fillable = [
        'artikelnr', 'naam','omschrijving','startdatum','einddatum'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function artikel()
    {
        return $this->belongsTo('App\Artikel', 'artikelnr', 'artikelnr');
    }
}
