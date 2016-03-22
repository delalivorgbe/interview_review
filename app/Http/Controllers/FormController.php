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

    /**
     * Create document request form
     *
     * @param  $request
     *
     * @return redirect()
     */
    public function formCreateForm(Request $request){

        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'format' => 'required'
        ]);

        $form = new Form();
        $form->title = $request['title'];
        $form->description = $request['instructions'];
        $form->format = $request['file-format'];
        $form->expiry_date = $request['expiry-date'];
        $request->user()->forms()->save($form);

        $message = 'Form creation failed';

        $form->save();

        $this->sendEmail();

//        if($form->save()){
//            $message = 'Request successfully created';
//        }

        return redirect()->route('forms')->with(['message' => $message]);
    }


    /**
     * Edit document request form
     *
     * @param  $request post request from form
     *
     * @return redirect()
     */
    public function formEditForm(Request $request){

        //Validate request
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'format' => 'required'
        ]);

        //Update form in DB
        $form = new Form();
        $form->title = $request['title'];
        $form->description = $request['instructions'];
        $form->format = $request['fileformat'];
        $form->expiry_date = $request['expirydate'];

        $request->user()->forms()->save($form);

        $form->save();

        return response()->json(['message' => $request['instructions']], 200);
    }


    /**
     * Get active document request forms
     *
     * @return view() view is placed in container using AJAX
     */
    public function getActiveDocRequests(){

        //TODO: Query that returns only active docs

        // Get forms
        $forms = Form::orderBy('created_at', 'desc')->get();

        // Get form responses
        $counts = DB::table('form_respondents')
            ->select(DB::raw('count(form_respondents.form_id) as num_resps, forms.id as form_id '))
            ->leftJoin('forms', 'form_respondents.form_id', '=', 'forms.id')
            ->groupBy('forms.id')
            ->get();

//        dd($counts);

        return view('include.doc_request_active', compact('forms','counts'));
    }


    //TODO: Merge above and below functions, pass ACTIVE / ARCHIVED as deterministic @param


    /**
     * Get archived document request forms
     *
     * @return view() view is placed in container using AJAX
     */
    public function getArchivedDocRequests(){

        //TODO: Query that returns only active docs

        $forms = Form::orderBy('created_at', 'desc')->get();

        $counts = DB::table('form_respondents')
            ->select(DB::raw('count(form_respondents.form_id) as num_resps, forms.id as form_id '))
            ->leftJoin('forms', 'form_respondents.form_id', '=', 'forms.id')
            ->groupBy('forms.id')
            ->get();

        return view('include.doc_request_archived', compact('forms' , 'counts'));
    }


    /**
     * Delete Document Request Form
     *
     * @param  $form_id
     *
     * @return redirect()
     */

    public function getDeleteForm($form_id){

        $form = Form::where('id', $form_id)->first();

        //Ensure sure only creator can destroy
        if(Auth::user() != $form->user){
            return redirect()->back();
        }

        $form->delete();
        return redirect()->route('forms')->with(['message' => 'Form deleted']);
    }


    /**
     * Edit Document Request Form
     *
     * @param  $request post request
     *
     * @return response() json object
     */

    public function getEditRequest(Request $request){

        $this->validate($request, [
            'title' => 'required',
            'instruction' => 'required',
            'expirydate' => 'required'
        ]);

        $form = Form::find($request['formId']);
        $form->title = $request['title'];
        $form->description = $request['instruction'];
        $form->format = $request['fileformat'];
        $form->expiry_date = $request['expirydate'];
        $form->update();

        return response()->json(
            ['new_title' => $form->title,
                'new_desc' => $form->description,
                'new_date' => $form->expiry_date->format(' D jS Y'),],
            200);

    }


    /**
     * Archive a Document Request Form
     *
     * @param  $form_id
     *
     * @return redirect()
     */
    public function getArchiveForm($form_id){

        // get form from DB
        $form = Form::where('id', $form_id)->first();

        // protect from other users
        if(Auth::user() != $form->user){
            return redirect()->back();
        }

        //update form status in DB
        $form->status = 'ARCHIVED';
        $form->update();


        return redirect()->route('forms')->with(['message' => 'Form archived']);
    }


    //TODO: Merge above and below functions pass @param to determine action


    /**
     * UnArchive a Document Request Form
     *
     * @param  $form_id
     *
     * @return redirect()
     */
    public function getUnarchiveForm($form_id){

        // get form from DB
        $form = Form::where('id', $form_id)->first();

        // protect from other users
        if(Auth::user() != $form->user){
            return redirect()->back();
        }

        //update form status in DB
        $form->status = 'ACTIVE';
        $form->update();

        return redirect()->route('forms')->with(['message' => 'Form unarchived']);
    }


    /**
     * Send emails
     */

    private function sendEmail(){

        $user = Auth::user();

        // get emails of recipients
        //TODO: currently sends email to all students get select list as necessary
        $emails = DB::table('students')
            ->select('students.email')
            ->distinct()
            ->get();

        //array to hold mails
        $mMails = array();
        $c = 0;

        foreach($emails as $email){
            $mMails[$c] =  $email->email;
            $c++;
        }

        //TODO: Configure laravel job queue to send mails in background
        // if emails array not empty queue emails
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
