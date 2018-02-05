<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artikel;
use Validator;
use \Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Cache;


class ArtikelsController extends Controller
{
    protected $generator;

    public function __construct()
    {
        $this->middleware('auth');
        $this->generator = new BarcodeGeneratorPNG();
    }

    public function getArtikel(Request $request)
    {
        $input = $request->input('query');

        if (Validator::make($request->all(), ['query' => 'digits:13'])->passes()) {
            return $this->getArtikelByEan($input);
        }
        return $this->getArtikelByDescription($input);
    }

    public function getArtikelByEan($ean)
    {
        try {
            $artikel = Cache::remember($ean, 60, function () use ($ean) {
                return Artikel::where('ean', $ean)->first();
            });
//            $artikel = Artikel::where('ean', $ean)->first();
            $barcode = $this->createBarcode($artikel->ean);

            return view('main')->with(['artikel' => $artikel, 'barcode' => $barcode]);
        } catch (\Exception $e) {
            return view('main')->with('notFound', 'Niets gevonden');
        }
    }

    public function getArtikelByDescription($description)
    {
        try {
            $artikel = Artikel::with('leverancier')->where('omschrijving', 'like', '%' . $description . '%')
                ->limit(200)->orderBy('omschrijving', 'ASC')->get();
            if ($artikel->isEmpty()) {
                throw new \Exception();
            }
            if ($artikel->count() === 1) {
                $artikel = $artikel->first();
                $barcode = $this->createBarcode($artikel->ean);
                return view('main')->with(['artikel' => $artikel, 'barcode' => $barcode]);
            }
            return view('main')->with('artikel', $artikel);
        } catch (\Exception $e) {
            return view('main')->with('notFound', 'Niets gevonden');
        }


    }

    public function getArtikelsOfLeverancier($leverancier)
    {
        $leverancierArtikels = Artikel::where('leverancier_id', $leverancier)->get();

        return view('main')->with('leverancierArtikels', $leverancierArtikels);
    }

    public function createBarcode($ean)
    {
        try {
            return $this->generator->getBarcode($ean, $this->generator::TYPE_EAN_13);
        } catch (\Exception $e) {
            return null;
        }
    }
}
