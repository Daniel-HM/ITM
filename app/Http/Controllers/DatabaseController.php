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

    public function artikel($db)
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
                            'omschrijving' => preg_replace('/[^[:alnum:][:space:][:punct:]]/', '', $field[2]),
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
            Storage::delete($this->db_path);
            return redirect('/')->with('status', 'Done!');
        }
    }

    public function leverancier($db)
    {
        $this->db_path = $db;
        if (file_exists($this->db_path)) {
            DB::transaction(function () {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                DB::table('leverancier')->truncate();
                $handle = fopen($this->db_path, "r");
                $i = 0;
                DB::table('leverancier')->insert([
                    'leverancier_id' => 0,
                    'naam' => 'Leverancier onbekend'
                ]);
                while (($field = fgetcsv($handle, 1000, ";")) !== false) {
                    if ($i > 0) {
                        DB::table('leverancier')->insert([
                            'leverancier_id' => $field[0],
                            'naam' => preg_replace('/[^[:alnum:][:space:][:punct:]]/', '', $field[1])
                        ]);
                    }
                    $i++;
                }

                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            });
        }
    }

    public function groep($db)
    {
        $this->db_path = $db;
        if (file_exists($this->db_path)) {
            DB::transaction(function () {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                DB::table('groep')->truncate();
                $handle = fopen($this->db_path, "r");
                DB::table('groep')->insert([
                    'groep_id' => 0,
                    'omschrijving' => 'Groep onbekend'
                ]);
                while (($field = fgetcsv($handle, 1000, ";")) !== false) {
                    DB::table('groep')->insert([
                        'groep_id' => $field[0],
                        'omschrijving' => preg_replace('/[^[:alnum:][:space:][:punct:]]/', '', $field[1])
                    ]);
                }

                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            });
        }
    }


    public function subgroep($db)
    {
        $this->db_path = $db;
        if (file_exists($this->db_path)) {
            DB::transaction(function () {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                DB::table('subgroep')->truncate();
                $handle = fopen($this->db_path, "r");
                DB::table('subgroep')->insert([
                    'groep_id' => 0,
                    'subgroep_id' => 0,
                    'omschrijving' => 'Subgroep onbekend'
                ]);
                while (($field = fgetcsv($handle, 1000, ";")) !== false) {
                    DB::table('subgroep')->insert([
                        'subgroep_id' => $field[0],
                        'omschrijving' => preg_replace('/[^[:alnum:][:space:][:punct:]]/', '', $field[1]),
                        'groep_id' => $field[2]
                    ]);
                }

                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            });
        }
    }

    public function promotie($db)
    {
        $this->db_path = $db;
        if (file_exists($this->db_path)) {
            DB::transaction(function () {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                DB::table('promotie')->truncate();
                $handle = fopen($this->db_path, "r");
                $i = 0;
                while (($field = fgetcsv($handle, 10000, ";")) !== false) {
                    $naam = preg_replace("/[^[:alnum:][:space:][:punct:]]/", "", $field[3]);
                    $artikelnr = $field[6];
                    $omschrijving = preg_replace('/[^[:alnum:][:space:][:punct:]]/', '', $field[15]);
                    $startdatum = $field[10];
                    $einddatum = $field[11];
                    if ($i > 0 && $artikelnr != '' && $naam != '' && $omschrijving != '') {
                        DB::table('promotie')->insert([
                            'naam' => $naam,
                            'artikelnr' => $artikelnr,
                            'omschrijving' => $omschrijving,
                            'startdatum' => $startdatum,
                            'einddatum' => $einddatum
                        ]);
                    }
                    $i++;
                }

                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            });
//            return redirect('/')->with('status', 'Done!');
            return view('home')->with('status', 'Done');
        }
    }
}
