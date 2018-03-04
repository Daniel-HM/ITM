<?php

namespace App\Http\Controllers;

use App\Artikel;
use App\Leverancier;
use Illuminate\Support\Facades\Cache;

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
    }

    /**
     * Show the application dashboard.
     *
     * @param Artikel $artikel
     * @return \Illuminate\Http\Response
     */
    public function index(Artikel $artikel)
    {
        $data['artikelCount'] =  Cache::remember('artikelCount', 60, function () use ($artikel) {
            return $artikel->count();
        });
        $data['leverancierCount'] = Cache::remember('leverancierCount', 60, function () {
            return Leverancier::count();
        });
        $data['activePromotieCount'] = Cache::remember('activePromotieCount', 60, function () use ($artikel){
            return $artikel->activePromoties()->count();
        });
        // REMOVE BEFORE DEPLOY
//        Cache::forget('artikelCount');
//        Cache::forget('leverancierCount');
//        Cache::forget('activePromotieCount');
        $data['lastArtikelDatabaseUpdate'] = Cache::get('lastArtikelDatabaseUpdate');
        return view('home')->with('data', $data);
    }

}
