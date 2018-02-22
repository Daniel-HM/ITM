<?php

namespace App\Jobs;

use App\Artikel;
use App\ArtikelStaging;
use App\Groep;
use App\Leverancier;
use App\Subgroep;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ProcessArtikels implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 180;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param ArtikelStaging $artikelStaging
     * @param Artikel $artikel
     * @param Leverancier $leverancier
     * @param Groep $groep
     * @param Subgroep $subgroep
     * @return void
     */
    public function handle(ArtikelStaging $artikelStaging, Artikel $artikel, Leverancier $leverancier, Groep $groep, Subgroep $subgroep)
    {
        Log::info('Artikel database processing has begun!');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($artikelStaging->groupBy('leverancier_id')->get() as $item) {
            $leverancier->firstOrCreate(['leverancier_id' => $item->leverancier_id], [
                'naam' => $item->leverancier_naam
            ]);
        }
        foreach ($artikelStaging->groupBy('subgroep_id')->get() as $item) {
            $groep->firstOrCreate(['groep_id' => $item->groep_id], ['omschrijving' => $item->groep_naam]);
            $subgroep->firstOrCreate(['subgroep_id' => $item->subgroep_id], ['omschrijving' => $item->subgroep_naam, 'groep_id' => $item->groep_id]);
        }
        $artikelStaging->chunk(1000, function ($items)use($artikel) {
            foreach ($items as $item) {
                $artikel->updateOrCreate(['ean' => $item->ean], [
                    'ean' => $item->ean,
                    'artikelnr' => $item->artikelnr,
                    'omschrijving' => trim($item->omschrijving),
                    'vkprijs' => str_replace(',', '.', $item->vkprijs),
                    'inkprijs' => str_replace(',', '.', $item->inkprijs),
                    'leverancier_id' => $item->leverancier_id,
                    'subgroep_id' => $item->subgroep_id
                ]);
            }
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Log::info('Artikel database processing is done!');
    }
}
