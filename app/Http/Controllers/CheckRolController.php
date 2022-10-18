<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rollen;
use App\Models\Permissions;
use App\Models\Rol_perm;
use Hash;
use Session;

class CheckRolController  extends Controller
{
    public function CheckRol(Request $request){
        $permdesc = $request->rol;
        if(Session()->has('loginId')){
            $data = User::where('id', '=',Session::get('loginId'))->first();
            $rol_id = $data->rol_id;
            $permissions = Permissions::all()->pluck('perm_id');
            foreach ($permissions as $permissions) {
                $rol_perm = Rol_perm::all()->where('perm_id', $permissions)->where('rol_id', $rol_id)->pluck('perm_id');
                $rol_perm = implode(json_decode($rol_perm));
                $test2 = Permissions::all()->where('perm_id', $rol_perm)->pluck('perm_desc');
                $test2 = implode(json_decode($test2));
                if($test2 == $permdesc){
                    echo $rol_perm;
                    echo $test2;
                    break;
                }
            }
            return redirect('./');
        }
    }
}
