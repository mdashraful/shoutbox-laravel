<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        $status = Status::orderBy('id', 'desc')->get();

        return view('public', ['status'=>$status]);
    }
    
}
