<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Chumper\Zipper\Facades\Zipper;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;


class FilePostController extends Controller
{

    public function postUploadFile(Request $request){

        $file = $request->file('file_to_upload');
        $filename = 'temp.csv';

        if($file){
            Storage::disk('local')->put($filename, File::get($file));
        }

        $this->parseCsv();

        return redirect()->route('students');
    }


    public function getUploadFile($filename){
        $file = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        return $file."".$filename;
    }


    public function parseCsv(){

        $csv = Reader::createFromPath($this->getUploadFile('temp.csv'));
        $csv->setOffset(1); //because we don't want to insert the header

        $nbInsert = $csv->each(function ($row) {

            DB::table('students')->insert(array(
                'first_name' => $row[0],
                'last_name' => $row[1],
                'age' => $row[2],
                'gender' => $row[3],
                'country' => $row[4],
                'class' => $row[5],
                'major' => $row[6],
                'student_id' => $row[7],
                'email' => $row[8],
                'telephone' => $row[9],
            ));

            return true; //if the function return false then the iteration will stop
        });

    }


    public function downloadZipArchive(){

//        $files = glob($this->getUploadFile('/f1'));
//
////        $files = glob('/storage/app/f1/*');
//        Zipper::make('test.zip')->add($files);

//        $files = glob('storage/app/fi/*');
//        Zipper::make('public/test.zip')->add($files);


//        Zipper::make('public/test.zip')->add($this->getUploadFile('download'));
//

        $zipper = new \Chumper\Zipper\Zipper;
        $zipper->make(storage_path('app/public/test.zip'))->folder('test')->add($this->getUploadFile('download') );

//        dd(Storage::disk('public')->exists('test.zip'));
        return response()->download(storage_path('app/public/test.zip'));

//        return redirect()->back();
    }

}

