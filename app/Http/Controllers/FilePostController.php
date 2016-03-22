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
use App\Form;


class FilePostController extends Controller
{

    /**
     * Upload student list CSV file
     *
     * @param  $request
     *
     * @return redirect()
     */
    public function postUploadFile(Request $request){

        //TODO: File validation, mime, extension etc.

        //get file from request
        $file = $request->file('file_to_upload');

        $success = false;

        $message = 'File upload failed';

        //if no file is gotten do nothing
        if($file){
            $filename = 'temp.csv'; //static file name, should overwrite existing file
            $success = Storage::disk('local')->put($filename, File::get($file));
        }else{
            redirect()->back();
        }

        if($success){
            $this->parseCsv($this->getUploadFile('temp.csv'));
        }

        return redirect()->route('students')->with(['message' => $message]);
    }



    /**
     * Get file from path
     *
     * @param  $filename
     *
     * @return string  path to file
     */
    public function getUploadFile($filename){
        $file = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        return $file."".$filename;
    }




    /**
     * Parse CSV file
     *
     * @param  $filepath
     *
     * @return boolean  success
     */
    public function parseCsv($filepath){

        $csv = Reader::createFromPath($filepath);
        $csv->setOffset(1); //because we don't want to insert the header

        //TODO: First parse file into array for success then attempt database access

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



    /**
     * Download zip folder containing
     *
     * @param  $formId
     *
     * @return response()
     */
    public function downloadZipArchive($formId){

//        Storage::delete(storage_path('app/public/test.zip'));

        $form = Form::where('id', $formId)->first();

        $sFormId = strval ($formId);
        $folderName = 'f'.''.$sFormId;

        $innerFolderName = strval($form->title).''.$sFormId;
        $innerFolderName = preg_replace('/\s+/', '', $innerFolderName);

        $downloadName = strval($form->title).''.$sFormId.'.zip';
        $downloadName = preg_replace('/\s+/', '', $downloadName);

        $zipper = new \Chumper\Zipper\Zipper;
        $zipper->make(storage_path('app/public/test.zip'))->folder('test')->add($this->getUploadFile($folderName) );

        return response()->download(storage_path('app/public/test.zip'));
    }

}

