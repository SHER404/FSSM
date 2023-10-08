<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\packages;
use App\Models\positions;
use App\Models\purchasedPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class PackagesController extends Controller
{
    public function index(){

        $user = Auth::user()->id;
        $userName= User::where('id',$user)->with('referral')->first();
        $packages = packages::all();
        $positions = positions::all();
        return view('modules.Packages.index',compact(['packages','userName','positions']));

   
        
    }

    public function store(Request $request){
        $purchasedPlan = new purchasedPlan();
        $purchasedPlan->user_id = $request->id;
        $purchasedPlan->position_id = $request->position_id;
        $purchasedPlan->package_id = $request->package_id;
        $purchasedPlan->direct_points= $request->eco_points;
        $purchasedPlan->register_points= $request->register_points;
        $purchasedPlan->total_amount= $request->total_amount;
        $purchasedPlan->save();
        return redirect()->back()->with('success', 'Your plan has been successfully purchased!');
    }

    
}
