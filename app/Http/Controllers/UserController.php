<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function signUp()
    {
        return view('signup');
    }

    public function makeSignUp(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        User::create(request(['name', 'email', 'password']));
    }
}
