<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\purchasedPlan;
use App\Models\packages;
use App\Models\User;
use Illuminate\Http\Request;

class PurchasedPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function allPackages(Request $request){
        $plans = purchasedPlan::with(['packages','user'])->get();
        return view('modules.All_User_Packages.index',compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

          ///////////////    Check Package
          
          $isPackage=User::where('id',$request->id)->whereNotNull('plan_id')->first();
          if($isPackage){
            return redirect()->back()->with('error', 'Package Already Exists!');
          }

          ///////////////    Check Package





        // User Selected Package
         
           $package_id=$request->package_id;
           $package=packages::find($package_id);
           $package_price=$package->package_price;
           $package_points=$package->package_points;
           $required_direct_points=$package_points/2;
           $required_register_points=$package_points/2;
           $package_direct_commission=$package->commission_points;
           $package_pair_commission=$package->pair_points;
           $package_bv=$package->bv;
        // User Selected Package end
        
       
        // User Entered Eco Points and Register Points 
           $direct_points=$request->direct_points;
           $register_points=$request->register_points;
           $total_points=$direct_points+$register_points;
        // User Entered Eco Points and Register Points  end

        // User balance
           $balanceEco=$this->checkDirectPoints($request->id);
           $balanceRegister=$this->checkRegisterPoints($request->id);
        // User balance end
       
        // Validations
        if($direct_points<$required_direct_points){
            return redirect()->back()->with('error', '50% Direct Points Required!');  
        }
        if($register_points>$required_register_points){
            return redirect()->back()->with('error', 'Only 50% Register Points Can be Used!');  
        }
        if($total_points<$package_points){
            return redirect()->back()->with('error', 'InSufficient  Points!');  
        }
        if($register_points>$balanceRegister){
            return redirect()->back()->with('error', 'InSufficient  Register Points!');  
        }
        // Validations end
        
        
        if($balanceEco==0){
            return redirect()->back()->with('error', 'You have 0 Direct Points!');  
        }else if($balanceEco<$direct_points){
            return redirect()->back()->with('error', 'InSufficient Direct Points!');  
        }else if($balanceRegister==0 && $total_points<$package_points){
            return redirect()->back()->with('error', 'You have 0 Register Points!');  
        }else if($balanceRegister<$register_points && $total_points<$package_points){
            return redirect()->back()->with('error', 'InSufficient Register Points!');  
        }else {
            // Finding Refral side Refral id
               $refral=$request->refral_id;
              
               $is_refral_side=$this->checkRefralSide($refral,$request->position);
               if(!$is_refral_side){
                return redirect()->back()->with('error', 'Refral Side Not Found!');  
               }
               $update_refral_side=$this->updateRefralSide($is_refral_side,$request->position,$request->id);
               

               
            // Finding Refral side Refral id end
            if($update_refral_side){
                $required_direct_points=$request->direct_points;
                $required_register_points=$request->register_points;
                $point_down_d=$this->updateDirectPoints($request->id,$required_direct_points,'down');
                $point_down_r=$this->updateRegisterPoints($request->id,$required_register_points,'down');
                $required_total_points=$required_direct_points+$required_register_points;
                $required_amount=$required_total_points*100;
                $purchasedPlan = new purchasedPlan();
                $purchasedPlan->user_id = $request->id;
                $purchasedPlan->position_id = $request->position;
                $purchasedPlan->package_id = $request->package_id;
                $purchasedPlan->direct_points = $required_direct_points;
                $purchasedPlan->register_points = $required_register_points;
                $purchasedPlan->total_amount = $required_amount;
                $purchasedPlan->save();
                ////////////////////////////// Update Plan
                  $this->updateUserPackage($request->id,$request->package_id);
                ////////////////////////////// Update Plan

                ///////////////// Direct refral Commission 
                $point_down_r=$this->updateCwallet($refral,$package_direct_commission,'up');
                $this->createDirectPointLogs($refral,$package_direct_commission,$request->position,'up');
                //////////////////// Direct Refral commission
                ///////////////// Bussiness Volume 
                // $networkUpline=  $this->findingUpline($request->id,$request->position);
                // if($networkUpline){
                //     foreach($networkUpline as $u){
                //     $Bv=$this->updateBv($u,$package_bv,$request->position,'up');
                //    }
                // }
                $upline =$this->findingUplineNew($request->id);
                if($upline){
                foreach($upline as $side => $users){
                    foreach($users as $user){
                        $Bv=$this->updateBv($user,$package_bv,$side,'up');
                    }
                }
                }
                   
                       
                  

                
                //////////////////// Bussiness Volume

                /////////////// Indirect Pair Commission
                //$IndirectCommission=$this->indirectPairCommission($refral,$package_bv,$request->position);
                /////////////// Indirect Pair Commission End 
                  
                //////////////////// Pair Check 
                $is_pair=$this->checkPair($is_refral_side);
                //dd($is_pair);
                if($is_pair){
                     ///////////////// Pair refral Commission 
                    /// $point_down_r=$this->updateCwallet($is_refral_side,$package_pair_commission,'up');
                     //////////////////// Pair Refral commission

                }
                
                    

               
                //////////////////// Pair Check
               
    
                return redirect()->back()->with('success', 'Your plan has been successfully purchased!');
            }else{
                return redirect()->back()->with('error', 'Not Done!');
            }

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\purchasedPlan  $purchasedPlan
     * @return \Illuminate\Http\Response
     */
    public function show(purchasedPlan $purchasedPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\purchasedPlan  $purchasedPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(purchasedPlan $purchasedPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\purchasedPlan  $purchasedPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, purchasedPlan $purchasedPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\purchasedPlan  $purchasedPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(purchasedPlan $purchasedPlan)
    {
        //
    }
}
