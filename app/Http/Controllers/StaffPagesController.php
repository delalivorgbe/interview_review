<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\Student;

class StaffPagesController extends Controller
{

    public function getDashboard(){
        return view('pages.dashboard');
    }

    public function getStudents(){

        $students = Student::all();
        return view('pages.students', ['students' => $students]);
    }


    public function getForums(){
        return view('pages.forum');
    }


    public function getForms(){
        return view('pages.forms');
    }

}
