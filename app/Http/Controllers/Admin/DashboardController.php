<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserKyc;
use App\Models\WithdrawTransactions;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public static function dashboard()
    {   
        if(auth()->user()->hasRole('User')){
            $data=User::find(Auth::user()->id);
        }else{
            $data=[];
            $data['totalMembers']= User::where('user_type','User')->count();
            $data['activeMembers'] = User::where('user_type','User')->where('status','Active')->count();
            $data['inactiveMembers'] = User::where('user_type','User')->where('status','Inactive')->count();
            $data['cbv'] = User::where('user_type','User')->sum('cbv');
            $data['leftRefralSide'] = User::where('user_type','User')->where('refral_side','Left')->count();
            $data['rightRefralSide'] = User::where('user_type','User')->where('refral_side','Right')->count();
            $data['e_wallet']=User::where('user_type','User')->sum('e_wallet');
            $data['onlineStoreWallet']=User::where('user_type','User')->sum('online_store_wallet');
            $data['ecoPoints']=User::where('user_type','User')->sum('eco_points');
            $data['left_bv']=User::where('user_type','User')->sum('bv_left');
            $data['right_bv']=User::where('user_type','User')->sum('bv_right');
            // $data['total_bv']=0;
            $data['total_withdraw']=WithdrawTransactions::where('status','Approved')->sum('amount');
            $data['withdraw_pending']=WithdrawTransactions::where('status','Pending')->sum('amount');
            $data['kyc_approved']=UserKyc::where('status','Approved')->count();
            $data['kyc_pending']=UserKyc::where('status','Pending')->count();
            $data['total_support']=0;
           

            //$data=User::where('user_type','User')->get();

            
        }
       
        return $data;
    }
    

    public function convertBv(){
        $data=User::where('user_type','User')->get();
        foreach($data as $d){
            $this->indirectPairCommission($d->id);
            $this->userRank($d->id);
        }
        return redirect()->back()->with('success','Converted Successfully');
    }
    public function userRank($id){
        $data='';
        $leftside=0;
        $rightside=0;
        $user=User::find($id);
        $refside=$this->checkWeaker($id);
        $refral_count= User::where('refral_id', $id)->get();
        foreach($refral_count as $ref){
            $refral_left= User::where('left_refral_side', $ref->id)->first();
            $refral_right= User::where('right_refral_side', $ref->id)->first();
            if($refral_left){
                $leftside++;
            }
            if($refral_right){
                $rightside++;
            }
        }
        $cbv=$user->cbv;
        if($cbv>=500 && $rightside>=2 && $leftside>=2){
            $data='Bronze Star';
        }
        if($cbv>=1200 && $rightside>=4 && $leftside>=4){
            $data='Silver Star';
        }
        if($cbv>=3000 && $rightside>=10 && $leftside>=10){
            $data='Gold Star';  
        }
        if($cbv>=7500){
            $ranks=$this->checkWeakerSidePackage($id,$refside,'Gold Star');
            if($ranks==1){
                $data='Platinum star'; 
            }
        }
        if($cbv>=10000){
            $ranks=$this->checkWeakerSidePackage($id,$refside,'Platinum star');
            if($ranks==1){
                $data='Ambassador Star'; 
            }
             
        }
        if($cbv>=35000){
            $ranks=$this->checkWeakerSidePackage($id,$refside,'Ambassador Star');
            if($ranks==1){
                $data='Ambassador Diamond  Star'; 
            }
             
        }
        if($cbv>=95000){
            $ranks=$this->checkWeakerSidePackage($id,$refside,'Ambassador Diamond  Star');
            if($ranks==1){
                $data='Global Ambassador Diamond Star';
            }
            
        }
        if($cbv>=450000){
            $ranks=$this->checkWeakerSidePackage($id,$refside,'Global Ambassador Diamond Star');
            if($ranks==1){
                $data='Crown Ambassador Diamond Star';
            }
            
        }
       
        $user->rank =$data;
        $user->save();
        return $user;
    }

   

    
}
