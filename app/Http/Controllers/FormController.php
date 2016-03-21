<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormRespondent;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendReminderEmail;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{

    public function formCreateForm(Request $request){

//        $this->validate($request,[
//            'title' => 'required',
//            'description' => 'required',
//            'format' => 'required'
//        ]);

        $form = new Form();

        $form->title = $request['title'];
        $form->description = $request['instructions'];
        $form->format = $request['file-format'];
        $form->expiry_date = $request['expiry-date'];

        $request->user()->forms()->save($form);
//
        $message = 'We blast';
//
        $form->save();

        $this->sendEmail();

//        if($form->save()){
//            $message = 'Request successfully created';
//        }

        return redirect()->route('forms')->with(['message' => $message]);
    }



    public function formEditForm(Request $request){


//        $this->validate($request,[
//            'title' => 'required',
//            'description' => 'required',
//            'format' => 'required'
//        ]);

        $form = new Form();

        $form->title = $request['title'];
        $form->description = $request['instructions'];
        $form->format = $request['fileformat'];
        $form->expiry_date = $request['expirydate'];

        $request->user()->forms()->save($form);
//
        $form->save();

        return response()->json(['message' => $request['instructions']], 200);

    }


    public function getActiveDocRequests(){

        $forms = Form::orderBy('created_at', 'desc')->get();

        return view('include.doc_request_active', ['forms' => $forms]);
    }

    public function getArchivedDocRequests(){
        $forms = Form::orderBy('created_at', 'desc')->get();
        return view('include.doc_request_archived', ['forms' => $forms]);
    }


    public function getDeleteForm($form_id){
        $form = Form::where('id', $form_id)->first();

        if(Auth::user() != $form->user){
            return redirect()->back();
        }

        $form->delete();
        return redirect()->route('forms')->with(['message' => 'Form deleted']);
    }


    public function getArchiveForm($form_id){

        $form = Form::where('id', $form_id)->first();

        if(Auth::user() != $form->user){
            return redirect()->back();
        }

        $form->status = 'ARCHIVED';
        $form->update();

        return redirect()->route('forms')->with(['message' => 'Form archived']);
    }


    public function getUnarchiveForm($form_id){

        $form = Form::where('id', $form_id)->first();

        if(Auth::user() != $form->user){
            return redirect()->back();
        }

        $form->status = 'ACTIVE';
        $form->update();


        return redirect()->route('forms')->with(['message' => 'Form unarchived']);
    }



    private function sendEmail(){

        $user = Auth::user();

        $emails = DB::table('students')
            ->select('students.email')
            ->distinct()
            ->get();

        $mMails = array();
        $c = 0;

        foreach($emails as $email){
            $mMails[$c] =  $email->email;
            $c++;
        }

        if(count($mMails) > 0){
            Mail::queue('emails.reminder', ['user' => $user], function ($m) use ($mMails) {
                $m->from('hello@app.com', 'ALU');

                $m->bcc($mMails)->subject('ALU: New Document Request');
            });
        }


//        $job = (new SendReminderEmail($user))->onQueue('emails');
//
//        $this->dispatch($job);

    }

}
