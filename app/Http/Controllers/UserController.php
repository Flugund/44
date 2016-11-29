<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserModel;

class UserController extends Controller
{
    public function show(UserModel $userModel, $id)
    {
        return $userModel->where('uid', $id)->with('feedbacks.feedbackCategory')->first();
    }
}
 