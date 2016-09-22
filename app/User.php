<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Relation;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'state'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    private $belows = [];

    /**
     * 自己本身的賠率
     */
    public function self_rate() {
        return $this->hasOne('App\Rate', 'id');
    }

    /**
     * 取得賠率 (下層往上找)
     */
    public function rate() {
        $rate = $this->self_rate;
        if (!$rate) {
            $rate = $this->findUpRate($this->up());
        }
        return $rate;
    }

    /**
     * 依序往上層找賠率
     */
    private function findUpRate($up) {
        //die(var_dump($up));
        if (!$up) {
            return null;
        }

        if (!$up->self_rate) {
            return $this->findUpRate($up->up());
        }

        return $up->self_rate;
    }

    /**
     * 取得上層使用者
     */
    public function up() {
        // 尋找上層ID
        $relation = $this->up_id;
        if (!$relation) {
            return null;
        }

        // 尋找上層User
        $up = $relation->parent;
        return $up;
    }

    /**
     * 取得上層ID
     */
    public function up_id() {
        return $this->hasOne('App\Relation', 'id');
    }

    public function belows_id() {
        return $this->hasMany('App\Relation', 'up');
    }

    public function allBelows() {
        $this->belows = [];
        foreach ($this->belows_id as $below_id) {
            $this->belows[] = $below_id->user;
        }
        $this->findBelows($this->belows);
        return $this->belows;
    }

    public function findBelows($belows = []) {
        foreach ($belows as $below) {
            $data = [];
            foreach ($below->belows_id as $below_id) {
                $this->belows[] = $below_id->user;
                $data[] = $below_id->user;
            }
            $this->findBelows($data);
        }
    }
}
