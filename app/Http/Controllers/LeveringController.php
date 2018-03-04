<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class LeveringController extends Controller
{
    protected $google_api_key;

    public function __construct()
    {
        $this->middleware('auth');
        $this->google_api_key = env('GOOGLE_API_KEY');
    }

    public function index()
    {
        return view('levering.home');
    }

    public function kosten(Request $request, $units = 'metric')
    {
        $straat = urlencode($request->input('straat'));
        $nummer = urlencode($request->input('nummer'));
        $stad = urlencode($request->input('stad'));

        $destination = $straat . '+' . $nummer . ',' . $stad;
        $origin = $request->input('vanuit');
        if ($origin == 'maldegem') {
            $origin = 'Aardenburgkalseide+301,Maldegem';
        } elseif ($origin == 'lovendegem') {
            $origin = 'Grote+Baan+249,Lovendegem';
        }

        $client = new Client();
        $res = $client->request('GET', 'https://maps.googleapis.com/maps/api/distancematrix/json?units=' . $units . '&origins=' . $origin . '&destinations=' . $destination . '&key=' . $this->google_api_key);
        $json = json_decode($res->getBody()->getContents(), true);
        $kilometer = round($json['rows'][0]['elements'][0]['distance']['value'] / 1000, 2, PHP_ROUND_HALF_DOWN);
        $kosten = $this->berekenen($kilometer);
        $request->flash();
        $embedUrl = 'https://www.google.com/maps/embed/v1/directions?key=' . $this->google_api_key . '&maptype=satellite&origin=' . $origin . '&destination=' . $destination;
        $origin = urldecode(str_replace(',', ', ', $origin));
        $destination = urldecode(str_replace(',', ', ', $destination));

        return view('levering.home')->with(compact('kosten', 'origin', 'destination', 'kilometer', 'embedUrl'));

    }

    public function berekenen($getal)
    {
        $getal = ($getal * 2) * 0.75;

        if ($getal % 5 == 0) {
            if ($getal < 10) {
                $getal = 10;
            }
            return 5 * round($getal / 5);
        }

        if ($getal < 10) {
            $getal = 10;
        }
        $getal = 5 * round($getal / 5);

        return $getal;

    }

}