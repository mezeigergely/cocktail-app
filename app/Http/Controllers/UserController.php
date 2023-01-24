<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

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
            'password' => 'required|confirmed'
        ]);
        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = base64_encode($request->password);
            $user->save();

            auth()->login($user);

            return redirect()->to('/profile');
        }
        catch(Exception $e){
            Log::error('Registration error!'.' '.$e);
            return Redirect::back()->withErrors(['emailError' => 'This e-mail is already exist in our system!']);
        }
    }

    public function signIn()
    {
        return view('login');
    }

    public function makeSignIn(Request $request)
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        try{
            $user = User::where('email', '=', $request->email)->first();
            auth()->login($user);

            return redirect()->to('/profile');
        }
        catch(Exception $e){
            Log::error('Login error!'.' '.$e);
            return Redirect::back()->withErrors(['emailError' => 'The email or password is incorrect, please try again']);
        }
    }

    public function profile()
    {
        return view('profile.profile');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->to('/');
    }
}
