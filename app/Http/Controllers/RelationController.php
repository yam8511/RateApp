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
        $master = Auth::user();
        if ($master->state > 3) {
            return redirect('/')->with('error', '你沒有權限');
        }
        $roles = ['Super', '廳主', '股東', '代理', '會員'];
        $ups = [];
        if ($master->state) {
            $ups[] = $master;
            foreach ($master->allBelows() as $below) {
                if ($below->state < 4) {
                    $ups[] = $below;
                }
            }
        } else {
            $users = User::whereIn('state', [1, 2, 3])->get();
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
            ],
            [
                'required' => '此欄位需填補',
                'name.max' => '名稱太長!',
                'email.unique' => '此帳戶已存在!',
                'email.email' => '請輸入有效Email',
                'password.min' => '密碼至少6碼',
                'password.confirmed' => '請重新輸入密碼, 確認密碼錯誤!',
                'state.min' => '請選擇對的角色',
                'state.max' => '請選擇對的角色',
                'up.exists' => '請選擇對的上層成員'
            ]
        );

        #檢查新增的上層會員是不是屬於自己的
        $seek = User::find($request->up);
        $ok = false;
        
        if ((!$master->state || $request->up == $master->id) && $seek) {
            $ok = true;
        }
        
        // 檢查是否為下層會員
        while (!$ok && $seek && $seek->state > $master->state) {
            if ($seek->id == $master->id) {
                $ok = true;
            }
            $seek = $seek->up();
        }

        if (!$ok) {
            return redirect('addBelow')->with('error', '上層會員有誤');
        }

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

    public function look() {
        $master = Auth::user();
        if ($master->state > 3) {
            return redirect('/')->with('error', '你沒有權限');
        }
        $roles = ['Super', '廳主', '股東', '代理', '會員'];
        $belows = [];
        if ($master->state) {
            foreach ($master->allBelows() as $below) {
                $belows[$below->state][] = $below;
            }
        }
        else {
            $users = User::all();
            foreach ($users as $user) {
                $belows[$user->state][] = $user;
            }
        }
        $data = ['master' => $master, 'roles' => $roles, 'belows' => $belows];
        return view('relation.look', $data);
    }

    public function seek($id) {

        $master = Auth::user();
        if ($id == $master->id) {
            return redirect('lookBelow');
        }

        $seek = User::find($id);
        $parent = $seek;
        $ok = false;
        
        if (!$master->state && $parent) {
            $ok = true;
        }
        
        // 檢查是否為下層會員
        while ($parent && $parent->state > 1 && !$ok) {
            if ($parent->up_id->up == $master->id) {
                $ok = true;
            }
            $parent = $parent->up();
        }

        if (!$ok) {
            return redirect('lookBelow')->with('error', '沒有下層會員');
        }


        $roles = ['Super', '廳主', '股東', '代理', '會員'];
        $belows = [];
        foreach ($seek->allBelows() as $below) {
            $belows[$below->state][] = $below;
        }

        $data = ['master' => $seek, 'roles' => $roles, 'belows' => $belows];

        return view('relation.look', $data);

    }
}
