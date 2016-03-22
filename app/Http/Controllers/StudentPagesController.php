<?php

namespace App\Http\Controllers;

use App\FormRespondent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Form;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;


class StudentPagesController extends Controller
{

    /**
     * Present student with Document Request Page
     *
     * @return view()
     */
    public function getDocReq(){
        return view('s_pages.sdocrequests');
    }

    /**
     * Present student with Forum Page
     *
     * @return view()
     */
    public function getForums(){
        return view('s_pages.sforums');
    }


    /**
     * Student response to Document Request
     *
     * @param  $request post request cotaining response
     *
     * @return redirect
     */
    public function postUploadDocument(Request $request){

        $file = $request->file('file_to_upload');

        $ext = Input::file('file_to_upload')->getClientOriginalExtension();
        $original_name = Input::file('file_to_upload')->getClientOriginalName();
        $size = Input::file('file_to_upload')->getSize();
        $mime = Input::file('file_to_upload')->getMimeType();

        $folder = 'f'.$request['form_id'];

        $username = Auth::user()->name;

        $username = preg_replace('/\s+/', '', $username);

        $filename = $folder.'/'.$username.'.'.$ext;

        if($file){
            Storage::disk('local')->put($filename, File::get($file));
        }

        $respondent = new FormRespondent();
        $respondent->doc_path = $filename;
        $respondent->form_id = $request['form_id'];
        $respondent->original_filename = $original_name;
        $request->user()->respondents()->save($respondent);

        $respondent->save();

        return redirect()->route('sdocreq');
    }


    /**
     * Get unfilled Document request forms for student
     *
     * @return view() with unfilled document requests
     */

    public function getStudentActiveDocRequests(){

        //get all document request that student has not filled
        $forms = DB::table('forms')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('form_respondents')
                    ->whereRaw('form_respondents.form_id = forms.id');
            })
            ->get();

        //$forms = Form::orderBy('created_at', 'desc')->get();
        return view('include.students.student-doc-req-active', ['forms' => $forms]);
    }


    /**
     * Get filled Document request forms for student
     *
     * @return view() with filled document requests
     */
    public function getStudentRespondedDocRequests(){

        $forms = DB::table('forms')
            ->join('form_respondents', 'forms.id', '=', 'form_respondents.form_id')
            ->select('forms.*', 'form_respondents.original_filename')
            ->distinct()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('include.students.student-doc-req-submitted', ['forms' => $forms]);
    }


    /**
     * Allow student to delete posted documents
     *
     * @return redirect()
     */
    public function getDeleteDocument($form_id){

//        if(Auth::user() != $form->user){
//            return redirect()->back();
//        }

        //TODO: Toggle status in DB instead of proper delete and delete file from disk

        DB::table('form_respondents')
            ->where('user_id', '=', Auth::user()->id)
            ->where('form_id', '=', $form_id)
            ->delete();

        return redirect()->route('sdocreq')->with(['message' => 'Form deleted']);
    }


}
