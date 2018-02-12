<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'image';
    protected $fillable = ['ean', 'name', 'leverancier_id'];
    public $timestamps = false;

    public function artikel()
    {
        return $this->belongsTo('App\Artikel', 'ean', 'ean');
    }
}
