<?php

namespace App\Http\Controllers;

use App\Artikel;
use App\DatabaseUpdates;
use App\Leverancier;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        Cache::tags(['homepageStats'])->remember('artikelCount', 60, function () {
            return Artikel::count();
        });
        Cache::tags(['homepageStats'])->remember('leverancierCount', 60, function () {
            return Leverancier::count();
        });
        Cache::tags(['homepageStats'])->remember('activePromotieCount', 60, function () {
            return Artikel::activePromoties()->count();
        });
    }

    /**
     * Show the application dashboard.
     *
     * @param Artikel $artikel
     * @param DatabaseUpdates $databaseUpdates
     * @return \Illuminate\Http\Response
     */
    public function index(Artikel $artikel, DatabaseUpdates $databaseUpdates)
    {
        // REMOVE BEFORE DEPLOY
        $data['artikelCount'] = Cache::tags(['homepageStats'])->get('artikelCount');
        $data['leverancierCount'] = Cache::tags(['homepageStats'])->get('leverancierCount');
        $data['activePromotieCount'] = Cache::tags(['homepageStats'])->get('activePromotieCount');
//        dd(Cache::tags(['homepageStats'])->get());

        $cache = Redis::get('name');
//        Cache::forget('artikelCount');
//        Cache::forget('leverancierCount');
//        Cache::forget('activePromotieCount');
        $derp = $databaseUpdates->latest()->first()->created_at;
        if ($derp) {
            $data['lastArtikelDatabaseUpdate'] = $derp;
        } else {
            $data['lastArtikelDatabaseUpdate'] = 'Onbekend';
        }
        return view('home')->with('data', $data);
    }

}
