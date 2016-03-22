<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\Student;

class StaffPagesController extends Controller
{

    /**
     * Present user with dashboard
     *
     * @return view()
     */

    public function getDashboard(){
        return view('pages.dashboard');
    }


    /**
     * Present user with forum
     *
     * @return view()
     */
    public function getForums(){
        return view('pages.forum');
    }


    /**
     * Present user with Document Request Page
     *
     * @return view()
     */
    public function getForms(){
        return view('pages.forms');
    }


    /**
     * Present student page
     *
     * @return view() with students
     */
    public function getStudents(){

        $students = Student::all();
        return view('pages.students', ['students' => $students]);
    }

}
