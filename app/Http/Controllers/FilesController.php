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
        $file = '_db';
        if ($request->hasFile($file)) {
            $request->file($file)->storeAs('', $request->file($file)->getClientOriginalName());
            return $this->databaseController->{$request->table}(storage_path('app/uploads/') . $request->file($file)->getClientOriginalName());
        }
    }
}
