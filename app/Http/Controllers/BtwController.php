<?php

namespace App\Http\Controllers;

use App\Btwnummer;
use Illuminate\Http\Request;
use SoapClient;

class BtwController extends Controller
{
    // Testing:
    // Gommers: NL008088421B01
    // IT VH: BE0458025783
    public function index()
    {
        return view('btw.home');
    }

    public function show(Request $request)
    {
        $countryCode = $request->input('countryCode');
        if ($countryCode === 'nl' or $countryCode === 'be') {
            $vatNumber = $request->input('vatNumber');
            $response = $this->validateVat($countryCode, $vatNumber);
            $request->flash();
            if ($response != false) {
                return view('btw.home')->with(['data' => $response, 'valid' => true]);
            }
        }
        return view('btw.home')->with('valid', false);
    }

    public function validateVat($countryCode, $vatNumber)
    {
        if ($response = Btwnummer::where('vatNumber', $vatNumber)->first()) {
            return $response;
        }
        $client = new SoapClient(env('VIES_WSDL'));
        $response = $client->checkVat([
            'countryCode' => $countryCode,
            'vatNumber' => $vatNumber
        ]);
        if ($response->valid === true) {
            $response->address = preg_replace('/^\s*(?:<br\s*\/?>\s*)*/i', '', nl2br($response->address));
            $btwnummer = Btwnummer::updateOrCreate(['vatNumber' => $response->vatNumber], [
                'name' => $response->name,
                'address' => $response->address,
                'vatNumber' => $response->vatNumber,
                'countryCode' => $response->countryCode
            ]);
            return $btwnummer;
        }
        return false;
    }
}
