<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Rate;
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
        $master = Auth::user();
        $data = ['user' => $master->rate ];

        if ($user->state == 0 || $user->state == 1) {
            return redirect('/')->with('success', '您不用設定賠率 :)');
        }
        
        return view('rate.set', $data);
    }

    public function setProcess(Request $request) {
        $master = Auth::user();
        $bg = $request->bg;
        $sg = $request->sg;
        $bb = $request->bb;
        $sb = $request->sb;

        $this->validate($request, [
            'sg' => 'required|numeric|min:0|max:'. $bg,
            'bg' => 'required|numeric|min:'. $sg .'|max:999999',
            'sb' => 'required|numeric|min:0|max:'. $sb,
            'bb' => 'required|numeric|min:'. $bb .'|max:'. $sg,
            ]
        );

        $rate = $master->rate;
        $rate->bg = $bg;
        $rate->sg = $sg;
        $rate->bb = $bb;
        $rate->sb = $sb;
        $rate->id = $master->id;
        if (!$rate->save()) {
            return redirect('setRate')->with('error', '儲存失敗');
        }

        return redirect('setRate')->with('success', '儲存成功');
    }
}
