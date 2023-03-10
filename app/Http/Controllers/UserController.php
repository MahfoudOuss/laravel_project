<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create(){
        return view('users/register');
    }
    public function store(Request $request){
        
        $formfields = $request->validate(
            [
                'name' =>'required|string|min:3',
                'email' =>['required','email',Rule::unique('users','email')],
                'password' =>'required|confirmed|min:6',
            ]
            );
            $formfields['password']=bcrypt($formfields['password']);
        
       

        $user = User::create($formfields);
        auth()->login($user);
        return redirect('/')->with('message','user created and logged in succesfully');
            
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message','logged out successfully');

    }
    public function login(){
        return view('users/login');
    }
    public function auth(Request $request){
        $formfields = $request->validate([
                'email' =>['required','email'],
                'password' =>'required',
            ]
            );
        if (Auth::attempt($formfields)) {
            $request->session()->regenerate();
            return redirect('/')->with('message','logged in successfully');
    
        }
        return back()->withErrors(['email'=>'invalid data'])->withInput();
        
    }
}
