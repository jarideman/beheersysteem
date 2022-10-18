<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;

class RegisterController  extends Controller
{
    public function registration(){
        return view("registration");
    }

    public function registerUser(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $res = $user->save();
        if($res){
            return back()->with('success','You have registered');
        }else{
            return back()->with('failed', 'Something went wrong');
        }
    }
}
