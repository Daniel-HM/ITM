<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Image;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class ScrapeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Scraper for Clayre & Eef website
     *  Save image to storage, EAN to database
     */
    public function scrape()
    {
        $goutteClient = new Client();
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
        ));
        $goutteClient->setClient($guzzleClient);
        $goutteClient->setHeader('user-agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");

        // Categorie 1 = home.php?cat=913
        // Laatste categorie = home.php?cat=1122

        $i = 908;
        while ($i <= 912) {
            $crawler = $goutteClient->request('GET', 'https://www.clayre-eef.nl/home.php?cat=' . $i);
            $pageFound = $crawler->filter('h1.category-title.f-left')->extract(['_text']);
            $pagination = $crawler->filter('td.NavigationCell')->extract(['_text']);
            if ($pageFound) {
                if ($pagination) {
                    $totalPages = trim(str_replace(array("\r\n", "\r", "\n", "\t"), "", preg_replace('/[^[:alnum:][:space:]]/', '', max($pagination))));
                } else {
                    $totalPages = 1;
                }
                for ($page = 1; $page <= $totalPages; $page++) {
                    $crawler = $goutteClient->request('GET', 'https://www.clayre-eef.nl/home.php?cat=' . $i . '&afurl=Y&sort=in_stock&sort_direction=1&page=' . $page);
                    $items = $crawler->filter('a.thumbnail-overlay')->extract(['href']);
                    foreach ($items as $item) {
                        $crawler = $goutteClient->request('GET', 'https://www.clayre-eef.nl/' . $item);

                        $image = $crawler->filter('img#zoom_01')->extract(['data-zoom-image']);
                        $ean = $crawler->filter('td')->eq(11)->extract(['_text']);
                        if ($ean) {
                            $eanFinal = str_replace(array("\r\n", "\r", "\n", "\t"), "", preg_replace('/[^[:alnum:][:space:]]/', '', $ean[0]));
                            if (!($eanFinal == 'Voorradig' || $eanFinal == 'Niet voorradig')) {
                                if ($this->doesImageExistRemotely($image[0])) {
                                    if (!Image::where('ean', $ean)->exists()) {
                                        $image_name = basename($image[0]);

                                        DB::statement('SET FOREIGN_KEY_CHECKS=0');
                                        Image::create([
                                            'ean' => $eanFinal,
                                            'name' => $image_name,
                                            'leverancier_id' => 300748
                                        ]);
                                        copy($image[0], '/home/vagrant/code/ITM/public/images/clayre/' . $image_name);
                                        DB::statement('SET FOREIGN_KEY_CHECKS=1');
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $i++;
        }
    }


    /**
     * @param $url
     * Check if image exists on a remote site
     * Thanks to Stackoverflow :)
     * @return bool
     */
    public function doesImageExistRemotely($url)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // $retcode >= 400 -> not found, $retcode = 200, found.
        curl_close($ch);
        if ($retcode == 200) {
            return true;
        }
        return false;
    }

}
