<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPromoties;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessArtikels;
use Symfony\Component\Process\Process;

class DatabaseStagingController extends Controller
{
    public $db_path;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function artikel_staging($db)
    {
        $this->db_path = $db;
        if (file_exists($this->db_path)) {
            DB::table('artikel_staging')->truncate();
            DB::transaction(function () {
                $query = 'LOAD DATA LOCAL INFILE \'' . $this->db_path . '\' INTO TABLE artikel_staging
FIELDS TERMINATED BY \';\'
LINES TERMINATED BY \'\r\n\'
IGNORE 2 LINES
(@dummy,@col2,@col3,@col4,@col5,@col6,@col7,@col8,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@col17,@col18,@col19,@col20)
 set ean=@col4,artikelnr=@col2,omschrijving=@col3,vkprijs=@col5,inkprijs=@col8,leverancier_id=@col6,leverancier_naam=@col7,subgroep_id=@col17,subgroep_naam=@col18,groep_id=@col19,groep_naam=@col20;';
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                DB::connection()->getpdo()->exec($query);
            });
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            ProcessArtikels::dispatch();
            Storage::delete($this->db_path);
            return redirect('/')->with('status', 'Database word verwerkt!');
        }
        return redirect('/')->with('status', 'Something went wrong.');
    }

    public function promotie_staging($db)
    {
        $this->db_path = $db;
        if (file_exists($this->db_path)) {
            DB::table('promotie_staging')->truncate();
            DB::transaction(function () {
                $query = 'LOAD DATA LOCAL INFILE \'' . $this->db_path . '\' INTO TABLE promotie_staging
FIELDS TERMINATED BY \';\'
LINES TERMINATED BY \'\r\n\'
IGNORE 1 LINES
(@dummy,@dummy,@dummy,@col4,@dummy,@dummy,@col7,@dummy,@dummy,@dummy,@col11,@col12,@dummy,@dummy,@dummy,@col16,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy)
 set naam=@col4,artikelnr=@col7,startdatum=@col11,einddatum=@col12,omschrijving=@col16;';
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                DB::connection()->getpdo()->exec($query);
            });
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            ProcessPromoties::dispatch();
            Storage::delete($this->db_path);
            return redirect('/')->with('status', 'Database word verwerkt!');
        }
        return redirect('/')->with('status', 'Something went wrong.');
    }

}