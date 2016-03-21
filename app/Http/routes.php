<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/setup', 'SocialController@getSetup');


Route::resource('fileposts', 'StaffPagesController');




/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

//    Route::get('/', function () {
//        return view('welcome');
//    });


    Route::get('auth/{provider?}', 'SocialController@getSocialAuth');
    Route::get('auth/{provider?}/callback', 'SocialController@getSocialAuthCallback');



    Route::get('/', [
        'uses' => 'SocialController@goToHome',
        'as' => 'home'
    ]);

    Route::get('/login', [
        'uses' => 'SocialController@goToHome',
        'as' => 'login'
    ]);



    Route::get('/logout', [
        'uses' => 'SocialController@getLogout',
        'as' => 'logout'
    ]);


    /*
     * Faculty & staff routes
     */

    Route::get('/setup', [
        'uses' => 'SocialController@getSetup',
        'as' => 'setup',
        'middleware' => 'auth'
    ]);

    Route::get('/dashboard', [
        'uses' => 'StaffPagesController@getDashboard',
        'as' => 'dashboard',
        'middleware' => ['auth','user.role','shield.from.students']
    ]);


    Route::get('/students', [
        'uses' => 'StaffPagesController@getStudents',
        'as' => 'students',
        'middleware' => ['auth','user.role','shield.from.students']
    ]);

    Route::get('/forum', [
        'uses' => 'StaffPagesController@getForums',
        'as' => 'forum',
        'middleware' => ['auth','user.role']
    ]);

    Route::get('/forms', [
        'uses' => 'StaffPagesController@getForms',
        'as' => 'forms',
        'middleware' => ['auth','user.role','shield.from.students']
    ]);


    //Student CSV Upload routes

    Route::post('/uploadfile', [
        'uses' => 'FilePostController@postUploadFile',
        'as' => 'file.upload'
    ]);


    Route::get('/csvfile/{filename}', [
        'uses' => 'FilePostController@getUploadFile',
        'as' => 'upload.file'
    ]);

    //End Student CSV Upload routes



    //Document Request Routes

    Route::get('/reqzip/{formId}', [
        'uses' => 'FilePostController@downloadZipArchive',
        'as' => 'download.files'
    ]);


    Route::post('/createdocreq', [
        'uses' => 'FormController@formCreateForm',
        'as' => 'doc.request'
    ]);



    Route::post('/docrequest', [
        'uses' => 'FormController@formCreateForm',
        'as' => 'docrequest'
    ]);



    Route::post('/requestdocument', [
        'uses' => 'FormController@formCreateForm',
        'as' => 'document.request'
    ]);


    Route::get('/archdownload/{formId}', [
        'uses' => 'FilePostController@downloadZipArchive',
        'as' => 'download.archive'
    ]);


    Route::get('/unarchiveform/{form_id}', [
        'uses' => 'FormController@getUnarchiveForm',
        'as' => 'form.unarchive',
        'middleware' => 'auth'
    ]);



    Route::get('/archiveform/{form_id}', [
        'uses' => 'FormController@getArchiveForm',
        'as' => 'form.archive',
        'middleware' => 'auth'
    ]);


    Route::get('/deleteform/{form_id}', [
        'uses' => 'FormController@getDeleteForm',
        'as' => 'form.delete',
        'middleware' => 'auth'
    ]);

    Route::get('/activedocreq', [
        'uses' => 'FormController@getActiveDocRequests',
        'as' => 'requests.active'
    ]);


    Route::get('/archiveddocreq', [
        'uses' => 'FormController@getArchivedDocRequests',
        'as' => 'requests.archived'
    ]);

//    Route::post('/editdocreq', function(\Illuminate\Http\Request $request){
//        return response()->json(['message' => $request['formId']
//      ]);
//    })->name('edit');


    Route::post('/editdocreq', [
        'uses' => 'FormController@getEditRequest',
        'as' => 'edit'
    ]);



    //End Document Request Routes


    /*
     * End Faculty & staff routes
     */




    /*
     * Student routes
     */

    Route::get('/sdocreq', [
        'uses' => 'StudentPagesController@getDocReq',
        'as' => 'sdocreq',
        'middleware' => ['auth','user.role','shield.from.staff']
    ]);

    Route::get('/sforum', [
        'uses' => 'StudentPagesController@getForums',
        'as' => 'sforum',
        'middleware' => ['auth','user.role','shield.from.staff']
    ]);


    Route::get('/studactivedocreq', [
        'uses' => 'StudentPagesController@getStudentActiveDocRequests',
        'as' => 'students.requests.active'
    ]);

    Route::get('/studsubmitteddocreq', [
        'uses' => 'StudentPagesController@getStudentRespondedDocRequests',
        'as' => 'students.requests.submitted'
    ]);


    Route::post('/uploaddoc', [
        'uses' => 'StudentPagesController@postUploadDocument',
        'as' => 'document.upload'
    ]);


    Route::get('/deletedoc/{form_id}', [
        'uses' => 'StudentPagesController@getDeleteDocument',
        'as' => 'document.delete'
    ]);

    /*
    * Student routes
    */

    Route::get('admin', function () {
        return view('layouts.admin_template');
    });


    Route::post('/setrole', [
        'uses' => 'SocialController@roleSetRole',
        'as' => 'role.set'
    ]);




});





