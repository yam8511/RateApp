<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RateController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        return view('rate.index');   
    }

    public function set() {
        return view('rate.set');
    }

    public function setProcess() {
        return redirect('setRate')->with('success', 'OK');
    }
}
