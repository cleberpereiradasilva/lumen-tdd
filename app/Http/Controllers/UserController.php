<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        //
    }

    public function store(Request $request){
        $user = new User($request->all());
        $user->save();
        return $user;
    }


}
