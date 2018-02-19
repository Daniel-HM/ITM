<?php

namespace App\Http\Controllers;

use App\Artikel;
use App\Leverancier;
use App\Image;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['artikelCount'] = Cache::remember('artikelCount', 60, function () {
            return Artikel::count();
        });
        $data['leverancierCount'] = Cache::remember('leverancierCount', 60, function () {
            return Leverancier::count();
        });
        $data['clayreImageCount'] = Cache::remember('clayreImageCount', 5, function () {
            return Image::where('leverancier_id', 300748)->count();
        });
        return view('home')->with('data', $data);
    }
}
