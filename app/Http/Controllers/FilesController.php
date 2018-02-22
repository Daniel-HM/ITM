<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    private $databaseStagingController;

    /**
     * FilesController constructor.
     * @param DatabaseStagingController $databaseStagingController
     */
    public function __construct(DatabaseStagingController $databaseStagingController)
    {
        $this->databaseStagingController = $databaseStagingController;
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('upload');
    }

    /**
     * @param Request $request
     * @return bool or file path
     */
    public function handleFile(Request $request)
    {
        $file = '_db';
        if ($request->hasFile($file)) {
            $request->file($file)->storeAs('', $request->file($file)->getClientOriginalName());
//            return $this->databaseController->{$request->table}(storage_path('app/uploads/') . $request->file($file)->getClientOriginalName());
            return $this->databaseStagingController->dispatchToRightStagingTable(storage_path('app/uploads/') . $request->file($file)->getClientOriginalName());
        }
        return false;
    }
}
