<?php

namespace App\Http\Controllers;

use App\Leverancier;
use Illuminate\Http\Request;
use App\Artikel;
use \Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Cache;


class ArtikelsController extends Controller
{
    protected $generator;
    private $artikel;

    /**
     * ArtikelsController constructor.
     * @param Artikel $artikel
     */
    public function __construct(Artikel $artikel)
    {
        $this->middleware('auth');
        $this->artikel = $artikel;
        $this->generator = new BarcodeGeneratorPNG();
    }


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getArtikel(Request $request)
    {
        $searchOption = $request->input('searchOption');
        $input = $request->input('query');
        $request->flash();
        switch ($searchOption) {
            case 'ean':
                return $this->show($this->artikel->getArtikelByEan($input));
                break;
            case 'naam':
                return $this->show($this->artikel->getArtikelByDescription($input));
                break;
            case 'artikelnr':
                return $this->show($this->artikel->getArtikelByArtikelnr($input));
                break;
            case 'leverancier':
                return $this->getLeverancier($input);
                break;
        }
        return redirect('/');
    }


    /**
     * @param $leverancier_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getLeverancierArtikels($leverancier_id)
    {
        $artikel = $this->artikel->getArtikelsOfLeverancier($leverancier_id);
        return $this->show($artikel, false);
    }

    public function getArtikelByEan($ean)
    {
        return $this->show($this->artikel->getArtikelByEan($ean));
    }


    /**
     * @param $artikel
     * @param bool $showLeverancierCol
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function show($artikel, $showLeverancierCol = true)
    {
        $artikelCount = count($artikel);
        try {
            if ($artikelCount === 0) {
                return back()->with(['message-type' => 'warning',
                    'message' => 'Niets gevonden']);
            }
            if ($artikelCount === 1) {
                $barcode = $this->createBarcode($artikel->ean);
                return view('artikel.show')->with(['artikel' => $artikel, 'barcode' => $barcode]);
            }
            return view('artikel.showlist')->with(['artikel' => $artikel, 'showLeverancierCol' => $showLeverancierCol]);
        } catch (\Exception $e) {
            return back()->with(['message-type' => 'danger',
                'message' => 'Er is iets fout gegaan..']);
        }
    }


    public function getLeverancier($query)
    {
        $leverancier = Leverancier::where('naam', 'LIKE', '%' . $query . '%')->limit(20)->orderBy('naam', 'ASC')->get();
        return view('artikel.leveranciers')->with(['leverancier' => $leverancier]);
    }

    public function showLeveranciers(Leverancier $leverancier)
    {
        return view('artikel.leveranciers')->with(['leverancier' => $leverancier->getAll()]);
    }

    public function showLastAddedArtikels()
    {
        $date = Cache::get('lastArtikelDatabaseUpdate');
        return view('artikel.showlist')->with(['artikel' => $this->artikel->latestArtikels($date), 'showLeverancierCol' => true]);
    }

    /**
     *
     */
    public function showArtikelsCurrentlyPromo()
    {
        return view('artikel.promo')->with(['promoArtikel' => $this->artikel->activePromoties(), 'showLeverancierCol' => true]);
    }

    /**
     * @param $ean
     * @return string (base64 image)
     */
    public function createBarcode($ean)
    {
        try {
            return $this->generator->getBarcode($ean, $this->generator::TYPE_EAN_13);
        } catch (\Exception $e) {
            return null;
        }
    }
}
