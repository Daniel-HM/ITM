<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public $db_path;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function insertDB($db)
    {
        $this->db_path = $db;
        if (file_exists($this->db_path)) {

            DB::transaction(function () {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                DB::table('artikel')->truncate();
                $handle = fopen($this->db_path, "r");
                $i = 0;
                while (($field = fgetcsv($handle, 1000, ";")) !== false) {
                    if ($i > 1) {
                        if ($field[3] == '') {
                            $field[3] = $i;
                        }
                        DB::table('artikel')->insert([
                            'ean' => $field[3],
                            'artikelnr' => $field[1],
                            'omschrijving' => preg_replace('/[^[:alnum:][:space:][:punct:]]/u', '', $field[2]),
                            'vkprijs' => preg_replace('/,/', '.', $field[4]),
                            'inkprijs' => preg_replace('/,/', '.', $field[7]),
                            'leverancier_id' => (int)$field[5],
                            'subgroep_id' => $field[16]
                        ]);
                    }
                    $i++;
                }

                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            });
            return redirect('/')->with('status', 'Done!');
        }
    }

    public function insertLeveranciers()
    {
        $db = getcwd() . '/db/leveranciers.csv';
        if (file_exists($db)) {
            DB::transaction(function () {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                $db = getcwd() . '/db/leveranciers.csv';
                DB::table('leverancier')->truncate();
                $handle = fopen($db, "r");
                $i = 0;
                DB::table('leverancier')->insert([
                    'leverancier_id' => 0,
                    'naam' => 'Leverancier onbekend'
                ]);
                while (($field = fgetcsv($handle, 1000, ";")) !== false) {
                    if ($i > 0) {
                        DB::table('leverancier')->insert([
                            'leverancier_id' => $field[0],
                            'naam' => preg_replace('/[^[:alnum:][:space:][:punct:]]/u', '', $field[1])
                        ]);
                    }
                    $i++;
                }

                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            });
        }
    }

    public function insertGroepen()
    {
        $groep = getcwd() . '/db/groep.csv';
        $subgroep = getcwd() . '/db/subgroep.csv';
        if (file_exists($groep)) {
            DB::transaction(function () use ($groep) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                DB::table('groep')->truncate();
                $handle = fopen($groep, "r");
                DB::table('groep')->insert([
                    'groep_id' => 0,
                    'omschrijving' => 'Groep onbekend'
                ]);
                while (($field = fgetcsv($handle, 1000, ";")) !== false) {
                    DB::table('groep')->insert([
                        'groep_id' => $field[0],
                        'omschrijving' => preg_replace('/[^[:alnum:][:space:][:punct:]]/u', '', $field[1])
                    ]);
                }

                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            });
            if (file_exists($subgroep)) {
                DB::transaction(function () use ($subgroep) {
                    DB::statement('SET FOREIGN_KEY_CHECKS=0');
                    DB::table('subgroep')->truncate();
                    $handle = fopen($subgroep, "r");
                    DB::table('subgroep')->insert([
                        'groep_id' => 0,
                        'subgroep_id' => 0,
                        'omschrijving' => 'Subgroep onbekend'
                    ]);
                    while (($field = fgetcsv($handle, 1000, ";")) !== false) {
                        DB::table('subgroep')->insert([
                            'subgroep_id' => $field[0],
                            'omschrijving' => preg_replace('/[^[:alnum:][:space:][:punct:]]/u', '', $field[1]),
                            'groep_id' => $field[2]
                        ]);
                    }

                    DB::statement('SET FOREIGN_KEY_CHECKS=1');
                });
            }
        }
    }
}
