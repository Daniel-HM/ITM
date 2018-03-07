<?php

namespace App\Jobs;

use App\Artikel;
use App\ArtikelStaging;
use App\DatabaseUpdates;
use App\Groep;
use App\Leverancier;
use App\Subgroep;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
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

    protected $db;

    /**
     * Create a new job instance.
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Execute the job. || 33K rows in ~31 sec (22/02/2018)
     *
     * @param ArtikelStaging $artikelStaging
     * @param Artikel $artikel
     * @param Leverancier $leverancier
     * @param Groep $groep
     * @param Subgroep $subgroep
     * @param DatabaseUpdates $databaseUpdates
     * @return void
     */
    public function handle(ArtikelStaging $artikelStaging, Artikel $artikel, Leverancier $leverancier, Groep $groep, Subgroep $subgroep, DatabaseUpdates $databaseUpdates)
    {
        Log::info('Artikel database processing has begun!');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $info = [
            'aantalArtikels' => $artikel->count(),
            'aantalLeveranciers' => $leverancier->count()
        ];
        $databaseUpdates->create(['type' => 'artikel', 'info' => json_encode($info)]);
        DB::table('artikel_staging')->truncate();
        DB::transaction(function () {
            DB::statement('SET NAMES utf8mb4');
            $query = 'LOAD DATA LOCAL INFILE \'' . $this->db . '\' INTO TABLE artikel_staging CHARACTER SET latin1
FIELDS TERMINATED BY \';\'
LINES TERMINATED BY \'\r\n\'
IGNORE 2 LINES
(@dummy,@col2,@col3,@col4,@col5,@col6,@col7,@col8,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@col17,@col18,@col19,@col20)
 set ean=@col4,artikelnr=@col2,omschrijving=@col3,vkprijs=@col5,inkprijs=@col8,leverancier_id=@col6,leverancier_naam=@col7,subgroep_id=@col17,subgroep_naam=@col18,groep_id=@col19,groep_naam=@col20;';
            DB::connection()->getpdo()->exec($query);
        });

        foreach ($artikelStaging->groupBy('leverancier_id')->get() as $item) {
            $leverancier->firstOrCreate(['leverancier_id' => $item->leverancier_id], [
                'naam' => $item->leverancier_naam
            ]);
        }
        foreach ($artikelStaging->groupBy('subgroep_id')->get() as $item) {
            $groep->firstOrCreate(['groep_id' => $item->groep_id], ['omschrijving' => $item->groep_naam]);
            $subgroep->firstOrCreate(['subgroep_id' => $item->subgroep_id], ['omschrijving' => $item->subgroep_naam, 'groep_id' => $item->groep_id]);
        }
        Cache::forever('lastArtikelDatabaseUpdate', Carbon::now()->format('Y-m-d H:i:s'));
        $artikelStaging->chunk(1000, function ($items) use ($artikel) {
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
        Cache::forget('latestArtikels');
        Cache::forget('activePromoties');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Log::info('Artikel database processing is done!');
    }
}
