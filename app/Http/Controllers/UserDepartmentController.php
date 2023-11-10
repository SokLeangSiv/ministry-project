<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDepartmentController extends Controller
{
    public function complaint(){

        $users = DB::table('tbl_case')->get()->first();

        return view('backend.investigation', compact('users'));
    }


}
