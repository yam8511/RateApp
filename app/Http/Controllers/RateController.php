<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class RateController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        return view('rate.index')->with('user', Auth::user());   
    }

    public function set() {
        $user = Auth::user();
        if ($user->state == 0 || $user->state == 1) {
            return redirect('/')->with('success', '您不用設定賠率 :)');
        }
        return view('rate.set');
    }

    public function setProcess() {
        return redirect('setRate')->with('success', 'OK');
    }
}
