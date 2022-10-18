<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\CheckRolController;
use App\Mail\NotifyMail;
use App\Models\User;
use App\Models\Rollen;
use App\Models\Permissions;
use App\Models\Rol_perm;
use Session;
use Hash;
use Mail;

class RedirectController extends Controller
{
    public function CheckRol($permdesc){
        $data = User::where('id', '=',Session::get('loginId'))->first();
        $rol_id = $data->rol_id;
        $permissions = Permissions::all()->pluck('perm_id');
        foreach ($permissions as $permissions) {
            $rol_perm = Rol_perm::all()->where('perm_id', $permissions)->where('rol_id', $rol_id)->pluck('perm_id');
            $rol_perm = implode(json_decode($rol_perm));
            $test2 = Permissions::all()->where('perm_id', $rol_perm)->pluck('perm_desc');
            $test2 = implode(json_decode($test2));
            if($test2 == $permdesc){
                return true;
            }
        }
    }

    //dashboards
    public function dashboard(){
        $permdesc='view_users';
        $data = User::where('id', '=',Session::get('loginId'))->first();
        $rol_id = $data->rol_id;
        $permissions = Permissions::all()->pluck('perm_id');
        foreach ($permissions as $permissions) {
            $rol_perm = Rol_perm::all()->where('perm_id', $permissions)->where('rol_id', $rol_id)->pluck('perm_id');
            $rol_perm = implode(json_decode($rol_perm));
            $test2 = Permissions::all()->where('perm_id', $rol_perm)->pluck('perm_desc');
            $test2 = implode(json_decode($test2));
            if($test2 == $permdesc){
                return redirect('admin_dashboard');
            }
        }
        return redirect('user_dashboard');
    }

    public function user_dashboard(){
        $permdesc='view_users';
        $data = User::where('id', '=',Session::get('loginId'))->first();
        $rol_id = $data->rol_id;
        $permissions = Permissions::all()->pluck('perm_id');
        foreach ($permissions as $permissions) {
            $rol_perm = Rol_perm::all()->where('perm_id', $permissions)->where('rol_id', $rol_id)->pluck('perm_id');
            $rol_perm = implode(json_decode($rol_perm));
            $test2 = Permissions::all()->where('perm_id', $rol_perm)->pluck('perm_desc');
            $test2 = implode(json_decode($test2));
            if($test2 == $permdesc){
                return redirect('admin_dashboard');
            }
        }
        $data = User::where('id', '=', Session::get('loginId'))->first();
        $rol = Rollen::where('id', '=' ,$data->rol_id)->pluck('name');
        $rol = implode(json_decode($rol));
        return view('user_dashboard',compact('data', 'rol'));
    }

    public function admin_dashboard(){
        $add = $this->CheckRol('add_users');
        $edit = $this->CheckRol('edit_users');
        $delete = $this->CheckRol('delete_users');
        $manage = $this->CheckRol('manage_perms');
        $rollen = Rollen::all();
        $info = User::all();
        return view('admin_dashboard', compact('add', 'edit', 'delete', 'info', 'manage', 'rollen'));
    }

    public function user_edit(Request $request) {
        $test = $this->CheckRol('manage_perms');
        $info = array();
        $info = User::where('id', '=', $request->id)->first();
        $rollen = Rollen::all();
        return view('edit', compact('info', 'rollen', 'test'));
    }

    public function edit(Request $request){
        $request->validate([     
            'name' => 'required', 
            'email' => 'required', 
        ]);
        User::where('id', '=', $request->id)->first()->update($request->all());
        return redirect('admin_dashboard')->with('success','User edited');
    }

    public function user_delete(Request $request){
        $test = $this->CheckRol('manage_perms');
        $info = array();
        $info = User::where('id', '=', $request->id)->first();
        $rollen = Rollen::all();
        return view('delete',compact('info', 'rollen', 'test'));
    }

    public function delete(Request $request){
        User::where('id', '=', $request->id)->first()->delete();
        return redirect('admin_dashboard')->with('success','User deleted');
    }

    public function user_add(){
        $test = $this->CheckRol('manage_perms');
        $rollen = Rollen::all();
        return view('/add', compact('rollen', 'test'));
    }

    public function add(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
        ]);
        $user = new User();
        $user->username = $request->name;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($request->rol_id) {
            $user->rol_id = $request->rol_id;
        }
        $res = $user->save();
        if($res){
            return redirect('admin_dashboard')->with('success','User created');
        }else{
            return redirect('admin_dashboard')->with('failed', 'Something went wrong');
        }
    }

    //rols dashboard
    public function PermissionsOphalen($request) {
        $rollen = array();
        $rollen = Rollen::where('id', '=', $request->id)->first();
        $permissions = Permissions::orderBy('perm_id')->get();
        $test= "";
        foreach ($permissions as $rij){
            $perm_name=$rij['perm_desc'];
            $permissions2=  $rij['perm_id'];
            $rol_perm = Rol_perm::all()->where('rol_id', '=', $request->id)->where('perm_id', '=', $permissions2);
            $test.= "<input type='checkbox' name='$perm_name'";
            foreach ($rol_perm as $row){
                $test.= "checked='checked'";
            }
            $test.= '> ' . $rij['text'] . '<br>';
        }
        return $test;
    }

    public function manage(){
        $addrol = $this->CheckRol('add_rols');
        $editrol = $this->CheckRol('edit_rols');
        $deleterol = $this->CheckRol('delete_rols');
        $rollen = Rollen::all();
        return view('manage', compact('rollen', 'addrol', 'editrol', 'deleterol'));
    }

    public function rol_edit(Request $request) {
        $test = $this->PermissionsOphalen($request);
        $rollen = Rollen::where('id', '=', $request->id)->first();
        return view('editrol',compact('test', 'rollen'));
    }

    public function editrol(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        $rolname = $request->name;
        Rollen::where('id', '=', $request->id)->update(['name' => $rolname]);
        $permissions = Permissions::all();
        foreach ($permissions as $row) {
            $perm_name = $row['perm_desc'];
            $perm_id = $row['perm_id'];
            $perm_name = $request->$perm_name;
            if ($perm_name == true) {
                $rol_perms = Rol_perm::where('rol_id', '=', $request->id)->where('perm_id', '=' , $perm_id)->count();
                if ($rol_perms == 1) {}
                else {
                    $rol_perm = new Rol_perm();
                    $rol_perm->rol_id = $request->id;
                    $rol_perm->perm_id = $perm_id;
                    $rol_perm = $rol_perm->save();
                }
            }
            else {
                Rol_perm::where('rol_id', '=', $request->id)->where('perm_id', '=', $perm_id)->delete();
            }
        }

        return redirect('manage')->with('success','Rol edited');
    }

    public function rol_delete(Request $request){
        $test = $this->PermissionsOphalen($request);
        $rollen = Rollen::where('id', '=', $request->id)->first();
        return view('deleterol',compact('test', 'rollen'));
    }

    public function deleterol(Request $request){
        Rollen::where('id', '=', $request->id)->first()->delete();
        Rol_perm::where('rol_id', '=', $request->id)->delete();
        return redirect('manage')->with('success','Rol deleted');
    }

    public function rol_add(Request $request){
        $test = $this->PermissionsOphalen($request);
        $rollen = Rollen::where('id', '=', $request->id)->first();
        return view('/addrol', compact('test', 'rollen'));
    }

    public function addrol(Request $request){
        $permissions = Permissions::all();
        $request->validate([
            'name'=>'required|unique:rollens',
        ]);
        $rol = new Rollen();
        $permissions = Permissions::all();
        $rol->name = $request->name;
        $rol = $rol->save();
        $rollen = Rollen::where('name', '=', $request->name)->pluck('id');
        $rollen = implode(json_decode($rollen));
        foreach ($permissions as $row) {
            $perm_name = $row['perm_desc'];
            $perm_id = $row['perm_id'];
            $rolvalue = $request->$perm_name;
            if ($rolvalue == true) {
                $rol_perm = new Rol_perm();
                $rol_perm->rol_id = $rollen;
                $rol_perm->perm_id = $perm_id;
                $rol_perm = $rol_perm->save();
            }
        }
        if($rol){
            return redirect('manage')->with('success','Rol created');
        }else{
            return redirect('manage')->with('failed', 'Something went wrong');
        }
    }

    //password reset
    public function passwordforgot(){
        return view('passwordforgot');
    }

    public function passwordreset(Request $request){
        $request->validate([ 
            'email' => 'required'   
        ]);
        $user = User::where('email', '=', $request->email)->first();
        if($user){
            $token= Str::random(60);
            Mail::to($request->email)->send(new NotifyMail($token));
            User::where('email', '=', $request->email)->update(['token' => $token]);
            return redirect('/')->with('reset', 'Mail has been send!');
        }
        else{
            return redirect('/')->with('failed', 'Email doesnt exists!');
        }
    }

    public function resetpassword(Request $request){
        $key = $request->token;;
        return view('resetpassword')->with('token', $key);
    }

    public function reset(Request $request){
         $request->validate([     
            'email' => 'required', 
            'password' => 'required_with:password_confirmation|same:password_confirmation|min:6',
            'password_confirmation' => 'required|min:6',
            'token' => 'required'
        ]);
        $user = User::where('email', '=', $request->email)->first();
        if ($user){
            $token = User::where('token', '=', $request->token)->first();
            if ($token){
                $password = Hash::make($request->password);
                $user->update(['password' => $password]);
                $token = '';
                User::where('email', '=', $request->email)->update(['token' => $token]);
                return redirect('/')->with('success','Password changed');
            }
            else{
                return redirect('/')->with('failed', 'Something went wrong try again!');
            }
        }
        else{
            return redirect('/')->with('failed', 'Email doesnt exists!');
        }   
    }
}
