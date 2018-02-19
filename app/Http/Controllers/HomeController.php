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
        $data['artikelCount'] = Artikel::count();
        $data['leverancierCount'] = Leverancier::count();
        $data['clayreImageCount'] = Image::where('leverancier_id', 300748)->count();
        return view('home')->with('data', $data);
    }
}
