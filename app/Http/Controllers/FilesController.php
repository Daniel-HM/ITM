<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DatabaseController;
use Storage;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function __construct(DatabaseController $databaseController)
    {
        $this->databaseController = $databaseController;
        $this->middleware('auth');
    }

    public function index()
    {
        return view('upload');
    }

    public function handleFile(Request $request)
    {

        if ($request->hasFile('_db')) {
            $request->file('_db')->storeAs('', 'database.csv');
            return $this->databaseController->insertDB(storage_path('app/uploads') . '/database.csv');
        }
    }
}
