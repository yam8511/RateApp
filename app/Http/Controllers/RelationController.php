<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Relation;
use App\User;
use Auth;

class RelationController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function add() {
        $roles = ['Super', '廳主', '股東', '代理', '會員'];
        $user = Auth::user();
        $ups = [];
        if ($user->state) {
            $ups[] = $user;
        }

        foreach ($user->belows as $below) {
            $ups[] = $below->user;
        }        

        $data = ['ups' => $ups, 'roles' => $roles, 'master' => $user->state ];
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

        if ($state != 0 && $state != 1) {
            $relation = new Relation();
            $relation->id = $user->id;
            $relation->up = $up;
            if (!$relation->save()) {
                $user->delete();
                return redirect('addBelow')->with('error', '層級新增失敗');
            }
        }
        
        return redirect('addBelow')->with('success', '新增成功');
        
    }
}
