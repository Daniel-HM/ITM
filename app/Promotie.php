<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotie extends Model
{

    /**
     * @var string
     */
    protected $table = 'promotie';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function artikel()
    {
        return $this->belongsTo('App\Artikel', 'artikelnr', 'artikelnr');
    }
}
