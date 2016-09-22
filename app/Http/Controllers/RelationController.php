<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Relation;
use App\Rate;
use App\User;
use Auth;

class RelationController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function add() {
        $roles = ['Super', '廳主', '股東', '代理', '會員'];
        $master = Auth::user();
        $ups = [];
        if ($master->state) {
            $ups[] = $master;
            foreach ($master->belows as $below) {
                $ups[] = $below->user;
            }
        } else {
            $users = User::all();
            foreach ($users as $user) {
                $ups[] = $user;
            }
        }

        $data = ['ups' => $ups, 'roles' => $roles, 'master' => $master->state ];
        return view('relation.add', $data);
    }

    public function addProcess(Request $request) {
        $master = Auth::user();
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $state = $request->state;
        $up = $request->up;
        
        $min = 0;
        $require = 'required|';
        if ($master->state) {
            $min = $master->state + 1;
        }

        if ($state == 0 || $state == 1) {
            $require = '';
        }

        // Validation
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'state' => 'required|numeric|min:'. $min .'|max:4',
            'up' => $require . 'numeric|exists:users,id,state,'. ( $state - 1 ),
            ]
        );

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->state = $state;

        if (!$user->save()) {
            return redirect('addBelow')->with('error', '新增失敗');
        }

        // 如果不是Super或廳主, 必須新增上層
        if ($state != 0 && $state != 1) {
            $relation = new Relation();
            $relation->id = $user->id;
            $relation->up = $up;
            
            if (!$relation->save()) {
                $user->delete();
                return redirect('addBelow')->with('error', '層級新增失敗');
            }
            
            // 如果是新增股東， 則必須新增賠率資料
            if ($state == 2) {
                $rate = new Rate();
                $rate->id = $user->id;
                $rate->bg = 0;
                $rate->sg = 0;
                $rate->bb = 0;
                $rate->sb = 0;
                if (!$rate->save()) {
                    $user->delete();
                    $relation->delete();
                    return redirect('addBelow')->with('error', '賠率設定失敗');
                }
            }
        }
        
        return redirect('addBelow')->with('success', '新增成功');
        
    }
}
