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

    public function set($id = null) {
        $master = Auth::user();
        if ($master->state > 3) {
            return redirect('/')->with('success', '您不用設定賠率 :)');
        }

        $data = ['user' => $master ];

        if ($id) {
            $seek = User::find($id);
            $parent = $seek;
            $ok = false;
            // 檢查是否為下層會員
            while ($parent && $parent->up_id && !$ok) {
                if (!$master->state) {
                    $ok = true;
                }
                if ($parent->up_id->up == $master->id) {
                    $ok = true;
                }
                $parent = $parent->up();
            }
            if (!$ok) {
                return redirect('lookBelow')->with('error', '沒有下層會員');
            }
            $master = $seek;

            $data = ['user' => $master, 'response' => url('seekBelow/'. $master->up_id->up) ];
        }

        return view('rate.set', $data);
    }

    public function setProcess(Request $request) {
        $master = Auth::user();
        if ($master->state > 3) {
            return redirect('/')->with('success', '您不用設定賠率 :)');
        }
        $bg = $request->bg;
        $sg = $request->sg;
        $bb = $request->bb;
        $sb = $request->sb;

        $response = 'setRate';
        if ($request->has('id')) {
            $master = User::find($request->id);
            if ($master->up_id->up == Auth::user()->id) {
                $response = 'lookBelow';
            }
            else {
                $response = 'seekBelow/'. $master->up_id->up;
            }
        }

        $this->validate($request, [
                'sb' => 'required|numeric|min:0|max:'. $bb,
                'bb' => 'required|numeric|min:0|max:'. $sg,
                'sg' => 'required|numeric|min:0|max:'. $bg,
                'bg' => 'required|numeric|min:0|max:'. ($master->up()->rate() ? $master->up()->rate()->bg : 999999) ,
            ],
            [
                'numeric' => '請輸入數字！',
                'required' => '此欄位需填補',
                'max' => '賠率不能大於 :max',
                'min' => '不能為負數',
            ]
        );

        $father = $master->up()->rate();
        $self_rate = $master->self_rate;
        $OK = true;

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
            elseif($self_rate) {
                if(!$self_rate->delete()) {
                    $OK = false;
                }
            }
        }

        if (!$OK) {
            return redirect($response)->with('error', '設定失敗');
        }

        return redirect($response)->with('success', '設定成功');
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

    public function synchronize(Request $request) {

        $master = Auth::user();
        if ($master->state > 3) {
            return redirect('/')->with('success', '您不用設定賠率 :)');
        }
        $belows = $master->allBelows();
        foreach ($belows as $below) {
            if ($below->self_rate) {
                if(!$below->self_rate->delete()) {
                    return redirect('setRate')->with('error', '同步失敗');
                }
            }
        }

        return redirect('setRate')->with('success', '同步成功');
    }

    public function setOther($id) {
        $master = Auth::user();
        if ($master->state > 3) {
            return redirect('/')->with('success', '您不用設定賠率 :)');
        }

        $data = ['user' => $master->rate() ];
        return view('rate.set', $data);
    }
}
