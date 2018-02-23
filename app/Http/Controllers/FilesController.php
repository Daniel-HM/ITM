<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    private $jobsController;

    /**
     * FilesController constructor.
     * @param JobsController $jobsController
     */
    public function __construct(JobsController $jobsController)
    {
        $this->jobsController = $jobsController;
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
            return $this->jobsController->dispatchToQueue(storage_path('app/uploads/') . $request->file($file)->getClientOriginalName());
        }
        return false;
    }
}
