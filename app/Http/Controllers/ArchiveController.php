<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{

  public function __construct()
  {
      return $this->middleware('auth');   
  }

  public function index()
  {

    return view('archives.index', [
      'files' => $files = Storage::allFiles('archives/'.date('F-Y', strtotime('-1 months')))
    ]);
  }

  public function downloadFile($name)
  {

    return response()->download(storage_path('app/archives/' . date('F-Y', strtotime('-1 months')). '/' . $name));
  }

  public function downloadAll()
  {

    $zip_file = date('F-Y', strtotime('-1 months')).'.zip';
    $zip = new \ZipArchive();
    $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

    $path = storage_path('app/archives/'.date('F-Y', strtotime('-1 months')));
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
    foreach ($files as $name => $file) {
      // We're skipping all subfolders
      if (!$file->isDir()) {
        $filePath     = $file->getRealPath();

        // extracting filename with substr/strlen
        $relativePath =  substr($filePath, strlen($path) + 1);

        $zip->addFile($filePath, $relativePath);
        
      }
    }
    $zip->close();
    return response()->download($zip_file);
  }

  public function generate(){
    
    $exitCode = Artisan::queue('Generate:PDFs');
    return back()->with('success','Statements are  being generated');
  }
}
