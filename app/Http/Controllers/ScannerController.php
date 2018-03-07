<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artikel;

class ScannerController extends Controller
{
    private $artikel;

    public function __construct(Artikel $artikel)
    {
        $this->artikel = $artikel;
    }

    public function index()
    {
        return view('scanner.index');
    }

    public function show(Request $request)
    {
        $input = $request->input('ean');
        $artikel = $this->artikel->getArtikelByEan($input);
        return view('scanner.index')->with('artikel', $artikel);
    }
}
