<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use Hash;
use Session;

class LoginController extends Controller
{
    public function loginUser(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user = User::where('email', '=',$request->email)->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                $request->session()->put('loginId',$user->id);
                $request->session()->put('role', $user->rol_id);
                return redirect('/dashboard');
            }else{
                return back()->with('failed', 'Password is incorrect');
            }
        }else {
            return back()->with('failed', 'This email is not registered');
        }
    }

    public function logout(){
        Session::pull('loginId');
        return redirect('/');
    }
}
