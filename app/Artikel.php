<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Artikel extends Model
{
    protected $table = 'artikel';
    public $fillable = ['ean', 'artikelnr', 'omschrijving', 'vkprijs', 'inkprijs', 'leverancier_id', 'subgroep_id', 'created_at', 'updated_at'];
    protected $with = ['leverancier', 'image', 'promotie'];


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
        return $this->hasOne('App\Promotie', 'ean', 'ean');
    }

    public function image()
    {
        return $this->hasOne('App\Image', 'ean', 'ean');
    }

    public function activePromoties()
    {
        $today = Carbon::now()->format('Y-m-d');
        $data = Cache::remember('activePromoties', 60, function () use ($today) {
            return $this->whereHas('promotie', function ($query) use ($today) {
                $query->where('startdatum', '<=', $today)->where('einddatum', '>=', $today);
            })->get();
        });
        return $data;

    }

    public function latestArtikels($date)
    {
        if ($date === null) {
            $date = '2018-01-01 00:00:00';
        }
        $data = Cache::rememberForever('latestArtikels', function () use ($date){
            return $this->where('created_at', '>=', $date)->latest()->limit(1000)->get();
        });
        return $data;
    }

    public function getArtikelsOfLeverancier($leverancier_id)
    {
        return $this->where('leverancier_id', $leverancier_id)
            ->orderBy('omschrijving')
            ->get();
    }

    public function getArtikelByEan($ean)
    {
        return $this->where('ean', $ean)->first();
    }

    public function getArtikelByDescription($description)
    {
        return $this->where('omschrijving', 'like', '%' . $description . '%')
            ->limit(200)->orderBy('omschrijving', 'ASC')->get();
    }

    public function getArtikelByArtikelnr($artikelnr)
    {
        return $this->where('artikelnr', 'like', '%' . $artikelnr . '%')
            ->limit(20)->orderBy('omschrijving', 'ASC')->get();
    }



}
