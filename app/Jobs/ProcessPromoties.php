<?php

namespace App\Jobs;

use App\Promotie;
use App\PromotieStaging;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessPromoties implements ShouldQueue
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
     * Execute the job.
     *
     * @param Promotie $promotie
     * @param PromotieStaging $promotieStaging
     * @return void
     */
    public function handle(Promotie $promotie, PromotieStaging $promotieStaging)
    {
        Log::info('Promo database processing has begun!');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('promotie_staging')->truncate();
        DB::transaction(function () {
            DB::statement('SET NAMES utf8mb4');
            $query = 'LOAD DATA LOCAL INFILE \'' . $this->db . '\' INTO TABLE promotie_staging CHARACTER SET latin1
FIELDS TERMINATED BY \';\'
LINES TERMINATED BY \'\r\n\'
IGNORE 1 LINES
(@dummy,@dummy,@dummy,@col4,@dummy,@col6,@col7,@dummy,@dummy,@dummy,@col11,@col12,@dummy,@dummy,@dummy,@col16,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy)
 set naam=@col4,ean=@col6,artikelnr=@col7,startdatum=@col11,einddatum=@col12,omschrijving=@col16;';
            DB::connection()->getpdo()->exec($query);
        });

        $promotieStaging->chunk(1000, function ($items) use ($promotie) {
            foreach ($items as $item) {
                if (!empty($item->artikelnr)) {
                    if (!empty($item->ean)) {
                        $promotie->updateOrCreate(['ean' => $item->ean], [
                            'ean' => $item->ean,
                            'artikelnr' => $item->artikelnr,
                            'omschrijving' => trim($item->omschrijving),
                            'naam' => trim($item->naam),
                            'startdatum' => $item->startdatum,
                            'einddatum' => $item->einddatum,
                        ]);
                    }
                }
            }
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Log::info('Promo database processing has ended.');
    }
}
