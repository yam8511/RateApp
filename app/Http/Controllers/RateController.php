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
        if ($master->state == 0 || $master->state == 1) {
            return redirect('/')->with('success', '您不用設定賠率 :)');
        }

        $data = ['user' => $master->rate() ];
        return view('rate.set', $data);
    }

    public function setProcess(Request $request) {
        $master = Auth::user();
        $bg = $request->bg;
        $sg = $request->sg;
        $bb = $request->bb;
        $sb = $request->sb;

        $father = $master->up()->rate();
        $self_rate = $master->self_rate;
        $OK = true;

        $this->validate($request, [
            'sb' => 'required|numeric|min:0|max:'. $bb,
            'bb' => 'required|numeric|min:0|max:'. $sg,
            'sg' => 'required|numeric|min:0|max:'. $bg,
            'bg' => 'required|numeric|min:0|max:999999',
            ]
        );

        # 已是最上層的賠率(股東)
        if (!$father) {
            $OK = $this->saveRate($request, $master);
        }
        else {
            # 與上層或原本賠率不同
            if ($bg != $father->bg || $sg != $father->sg || 
                $bb != $father->bb || $sb != $father->sb) {
                $OK = $this->saveRate($request, $master);
            }
            # 與上層賠率相同
            else if($self_rate && !$self_rate->delete()){
                $OK = false;
            }
        }

        if (!$OK) {
            return redirect('setRate')->with('error', '儲存失敗');
        }

        return redirect('setRate')->with('success', '儲存成功');
    }

    private function saveRate($request, $user) {

        $self_rate = $user->self_rate;

        if (!$self_rate) {
            $self_rate = new Rate();
            $self_rate->id = $user->id;
        }

        $self_rate->bg = $request->bg;
        $self_rate->sg = $request->sg;
        $self_rate->bb = $request->bb;
        $self_rate->sb = $request->sb;

        if (!$self_rate->save()) {
            return false;
        }
        return true;
    }
}
