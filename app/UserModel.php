<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    public $table = "users";

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback', 'userid', 'uid');
    }
}
