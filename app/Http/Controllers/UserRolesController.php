<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserRolesController extends Controller
{
    public function index()
    {
        return view('user-roles.index');
    }

    public function form()
    {
        return view('user-roles.form');
    }
}
