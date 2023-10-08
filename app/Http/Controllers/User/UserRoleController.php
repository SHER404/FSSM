<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;


class UserRoleController extends Controller
{
    public static function  allRoles(){
        $data = Role ::select('name')->get();
        $roles =array();
        foreach($data as $role){
            $roles[] = $role->name;
        }
        return $roles;
    }
    public function createRole(){

        $role = "User";

        $role = Role::create(['name' => $role]);

        return "Role Created";

    }

    public function createPermission(){

        $permission = "direct_points";

        $permission = Permission::create(['name' => $permission]);

        return "Permission Created";

    }
    public function changePermission(Request $request){

        $user_id = $request->user_id;
        $type = $request->action;
        $permission = $request->permission;
        
        if($type=='add'){
          
        $perm = Permission::find($permission);
        $user = User::find($user_id);
        $user->givePermissionTo($perm);
        }else{
            $perm = Permission::find($permission);
            $user = User::find($user_id);
            $user->revokePermissionTo($perm);
        }
        

        return redirect()->back()->with('success','Permission Updated Successfully');

    }
    public function assignPermission(){

        $permission = 19;
        $role = 1;

        $permission = Permission::find($permission);
        $role = Role::find($role);

        //$permission->assignRole($role);
        $role->givePermissionTo($permission);

        //print_r($permission);

        return "Permission Assigned";

    }

    public function assignRole(){

        $user = 2;

        $user = User::find($user);

        $user->assignRole('User');

        return "Role Assigned";

    }

}
