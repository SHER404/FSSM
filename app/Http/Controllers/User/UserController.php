<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\packages;
use App\Models\purchasedPlan;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{

  

    public function update(Request $request,$id){

        $existUser = User::where('email', $request->email)->where('id', '!=', $id)->first();
        if($existUser){
            return redirect()->back()->with('error','Email Already Exist');
        }
        $existUsername = User::where('name', $request->name)->where('id', '!=', $id)->first();
        if($existUsername){
            return redirect()->back()->with('error','Username Already Exist');
        } 
        $existFullName = User::where('full_name',$request->full_name)->where('id', '!=', $id)->first();
        if($existFullName){
            return redirect()->back()->with('error','Full Name Already Exist');
        }
    
        $data = User::find($id);
        $data->update($request->all());
        return redirect()->back()->with('success','Profile Updated Successfully');
    }

    public function UserProfile(){
        $user = Auth::user()->id;
        $data = User::find($user);
        return view('modules.User_Profile.user_Profile',compact(['data']));

    }
    public function UserShow(Request $request){
        $data = User::find($request->user_id);
        return view('modules.Users.user_Profile',compact(['data']));
    }
    public function networkSummary()
    {   
        
            $network=[];
            $network['paid_left']=$this->checkNodes(Auth::user()->left_refral_side);
            $network['paid_right']= $this->checkNodes(Auth::user()->right_refral_side);
            $network['bv_left']= Auth::user()->bv_left;
            $network['bv_right']= Auth::user()->bv_right;
            $network['ref_left']=  $this->checkRef(Auth::user()->id,'Left');
            $network['ref_right']=  $this->checkRef(Auth::user()->id,'Right');
            $network['user_name_own']= Auth::user()->name;
            $network['user_package_own']= Auth::user()->package?->packages ?? 'Unpaid';
            $network['referred_by']= Auth::user()->referral?->name;
            $network['cbv']= Auth::user()->cbv;
            $network['rank']= Auth::user()->rank;
            return view('modules.Network_Summary.index',compact(['network']));
    }
    public function userPassword(Request $request)
    {
        
        $user =User::where('id',$request->user_id)->first();
        return view('modules.Users.updatePassword',compact(['user']));

    }
    public function editUser(Request $request)
    {
        
        $user =User::where('id',$request->user_id)->first();
        return view('modules.Users.edit',compact(['user']));

    }


    public function updateUser(Request $request)
    {
       
         $user =User::where('id','!=',$request->user_id)->where('name',$request->name)->first();
        
         if($user){
            // dd($user);
            return \Redirect::to('users/?error=Username Already Exists');
         
         }

        $data =User::where('id',$request->user_id)->update(['name'=> $request->name,'full_name' => $request->full_name]);
            
        return \Redirect::to('users/?success=Updated Successfully');
       
       
    }
   
    public function updatePassword(Request $request)
    {
        // Get the authenticated user
        $user =User::where('id',$request->user_id)->first();
    // Check if the old password matches the user's current password
  
    if (!Hash::check($request->old_password, $user->password)) {
          return redirect()->intended('/users')->with('error', 'Old Password is Incorrect');
    }
    
    // Update the user's password
    $user->password = Hash::make($request->new_password);
    $user->string_password = $request->new_password;
    $user->save();
    
    
    return redirect()->intended('/users')->with('success', 'password has been updated.');
       
       
    }
    public function myPassword(Request $request)
    {
        // Get the authenticated user
    $user = auth()->user();
    // Check if the old password matches the user's current password
  
    if (!Hash::check($request->old_password, $user->password)) {
        return redirect()->back()->with('error', 'Old Password is Incorrect');
    }
    
    // Update the user's password
    $user->password = Hash::make($request->new_password);
    $user->string_password = $request->new_password;
    $user->save();
    
    return redirect()->back()->with('success', 'Your password has been updated.');
       
       
    }

    public function networkSummaryRefrals(Request $request)
    {       
            $user_id=$request->user_id;
            $user =User::where('id',$user_id)->first();
        
            $network=[];
            $network['paid_left']= $this->checkNodes($user->left_refral_side);
            $network['paid_right']= $this->checkNodes($user->right_refral_side);
            $network['bv_left']= $user->bv_left;
            $network['bv_right']= $user->bv_right;
            $network['ref_left']=  $this->checkRef($user_id,'Left');
            $network['ref_right']=  $this->checkRef($user_id,'Right');
            $network['user_name_own']= $user->name;
            $network['user_package_own']= $user->package?->packages ?? 'Unpaid';
            $network['referred_by']= $user->referral?->name;
            $network['cbv']= $user->cbv;
            $network['rank']= $user->rank;
           
            return response(['data'=>$network],200);
    }
    public function checkNodes($id){
        $user =User::where('id',$id)->first();
        if(!$user){
            return 0;
        }
        if($user){
               return ( 1 + $this->checkNodes($user->left_refral_side) + $this->checkNodes($user->right_refral_side));
        }
    }
   public function checkNetworkBv($id,$side){

    $done=0;
    $count=0;
   $user_id=$id;
   if($side=='Left'){
       while($done==0){
           $user =User::where('id',$user_id)->whereNotNull('left_refral_side')->first();
           if($user){
               $user_id=$user->left_refral_side;
               $count+=$user->bv_left;
           }else{
               $done=1;
           }
       }  
   }else if($side=='Right'){
       while($done==0){
           $user =User::where('id',$user_id)->whereNotNull('right_refral_side')->first();
           if($user){
               $user_id=$user->right_refral_side;
               $count+=$user->bv_right;
           }else{
               $done=1;
           }
       }  
   }
  

   return $count;


}

public function checkRef($id,$side){

    $count=0;
   $user_id=$id;
   $user = User::where('refral_id',$user_id)->get();
   foreach($user as $u){
       if($side=='Left'){
        $user =User::where('left_refral_side',$u->id)->first();
        if($user){
         $count++;
        }

       }else if($side=='Right'){
        $user =User::where('right_refral_side',$u->id)->first();
        if($user){
         $count++;
        }
       }

   }
   return $count;
}

public function logout(Request $request)
{
    Auth::guard('web')->logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
 
    return redirect('/');
}
    public function checkRefral(Request $request)
    {  
        $data= User::where('name', $request->name)->first();

        return response(['data'=>$data],200);
    }
    public function myReferrals()
    {  
        $data= User::where('refral_id', Auth::user()->id)->get();
        return view('modules.referrals.index',compact(['data']));
    }
    public function drawTree(Request $request)
    {  
        $data= User::where('id',$request->id)->with(['left','right'])->first();
        return response(['data'=> $data],200);;
    }
    public function myReferral_tree(Request $request)
    {  
        if($request->user_name){
            $data= User::where('name',$request->user_name)->with(['left','right'])->first();
            
        }else{
            $data= User::where('id',$request->user_id)->with(['left','right'])->first();
        }
      
        return view('modules.referrals.refral_tree',compact(['data']));
    }
    public static function myReferralSides($id)
    {  
        $user= User::find($id);
        
        return $user;
    }
    
    public function getUserDetail(Request $request)
    {  
        $data= User::where('name', $request->name)->first();
     
        return response(['data' => $data],200);
    }
      public function allUsers(Request $request){
            $user = Auth::user();
            if($user->user_type == 'Admin'){
                $data = User::where('id','!=',$user->id)->get();
                return view('modules.Users.index',compact(['data']));
            }
            else{
                return redirect()->back()->with('error','You are not authorized to view this page');
        }
     }

     
    public function deactivateUser(Request $request){
        $user = User::find($request->id);
        $user->removeRole('User');
        $user->status = 'InActive';
        $user->save();
        return redirect()->back()->with('success','User Deactivated Successfully');
    }


  public function activateUser(Request $request){
        $user = User::find($request->id);
        $user->assignRole('User');
        $user->status = 'Active';
        $user->save();
        return redirect()->back()->with('success','User Activated Successfully');
  }

  public function deleteUser(Request $request){
        $user = User::find($request->id);
        $user->removeRole('User');
        $user->delete();

        $user_left = User::where('left_refral_side' , $request->id)->update(['left_refral_side' => null]);
        $user_right = User::where('right_refral_side' , $request->id)->update(['right_refral_side' => null]);
        $package =purchasedPlan::where('user_id' , $request->id)->first();
        $package->delete();
        return redirect()->back()->with('success','User Deleted Successfully');
  }
}