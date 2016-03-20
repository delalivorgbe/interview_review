<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Chumper\Zipper\Facades\Zipper;

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
        $file = Storage::disk('local')->get($filename);
        return $file;
    }


    public function parseCsv(){
        Excel::load('/storage/app/temp.csv', function($reader) {

            $reader->each(function($newStudent) {

                if (!($authUser = Student::where('student_id', (string)(int)$newStudent->student_id)->first())) {
                    $student = new Student();
                    $student->first_name = $newStudent->first_name;
                    $student->last_name = $newStudent->last_name;
                    $student->age = (int)$newStudent->age;
                    $student->gender = $newStudent->gender;
                    $student->country = $newStudent->country;
                    $student->class = (int)$newStudent->class;
                    $student->major = $newStudent->major;
                    $student->student_id = (int)$newStudent->student_id;
                    $student->email = $newStudent->email;
                    $student->telephone = $newStudent->telephone;

                    $student->save();
                }

            });

        });
    }


    public function downloadZipArchive(){

        $files = glob($this->getUploadFile('/f9'));

//        $files = glob('/storage/app/f9/*');
        Zipper::make('test.zip')->add($files);

        return response()->download($this->getUploadFile('/temp.csv'));

//        return redirect()->back();
    }

}

