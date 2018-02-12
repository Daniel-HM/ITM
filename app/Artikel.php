<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{

    protected $table = 'artikel';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leverancier()
    {
        return $this->belongsTo('App\Leverancier', 'leverancier_id', 'leverancier_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subgroep()
    {
        return $this->belongsTo('App\Subgroep', 'subgroep_id', 'subgroep_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function promotie()
    {
        return $this->hasOne('App\Promotie', 'artikelnr', 'artikelnr');
    }

    public function image()
    {
        return $this->hasOne('App\Image', 'ean', 'ean');
    }


}
