<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    public function user() {
        return $this->hasOne('App\User', 'id', 'id');
    }
}
