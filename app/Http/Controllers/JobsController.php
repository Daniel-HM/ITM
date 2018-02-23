<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessArtikels;
use App\Jobs\ProcessPromoties;

class JobsController extends Controller
{
    protected $db;

    public function dispatchToQueue($db)
    {
        $this->db = $db;
        if (file_exists($this->db)) {
            if (($handle = fopen($this->db, "r")) !== FALSE) {
                while (($field = fgetcsv($handle, 1000, ";")) !== false) {
                    if ($field[0] === '32084') {
                        fclose($handle);
                        ProcessArtikels::dispatch($this->db);
                        return redirect('/')->with('status', 'Database word verwerkt!');
                    } elseif ($field[0] === 'Actiecode') {
                        fclose($handle);
                        ProcessPromoties::dispatch($this->db);
                        return redirect('/')->with('status', 'Database word verwerkt!');
                    }
                    return redirect('/upload')->with('status', 'Something went wrong');
                }
            }
        }
        return redirect('/upload')->with('status', 'Something went wrong');
    }
}
