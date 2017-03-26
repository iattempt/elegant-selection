<?php

namespace App\Http\Controllers\Student\Selection\Enroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Student\Selection\EnrollController;

class InRequiredController extends EnrollController
{
    //
    function __construct () {
        parent::__construct();
        $this->general->title = "Enroll in-required";
    }
    function index() {
        return view('student/selection/enroll/in_required', ['general' => $this->general]);
    }
}
