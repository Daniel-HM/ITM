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
     * @param Promotie $promotie
     * @param PromotieStaging $promotieStaging
     * @return void
     */
    public function handle(Promotie $promotie, PromotieStaging $promotieStaging)
    {
        Log::info('Promo database processing has begun!');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $promotieStaging->chunk(1000, function ($items) use ($promotie) {
            foreach ($items as $item) {
                if (!empty($item->artikelnr)) {
                    $promotie->updateOrCreate(['artikelnr' => $item->artikelnr], [
                        'artikelnr' => $item->artikelnr,
                        'omschrijving' => trim($item->omschrijving),
                        'naam' => trim($item->naam),
                        'startdatum' => $item->startdatum,
                        'einddatum' => $item->einddatum,
                    ]);
                }
            }
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Log::info('Promo database processing has ended!');
    }
}
