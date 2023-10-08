@extends('layout.layout')
 @section('content')

<div class="layout-px-spacing">
	<div class="middle-content container-xxl p-0">

	<section style="background-color: #eee;">
  <div class="container py-5">
    <div class="row bg-light rounded-3 p-3 mb-4">
      <div class="col-6">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Account Details</a></li>
            <li class="breadcrumb-item active" aria-current="page">Update Account Details</li>
          </ol>
        </nav>
      </div>
      <div class="col-6">
        <div class="d-flex justify-content-end">
         
        </div>
        
    </div>
    </div>
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                            <br>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                            <br>
                        @endif
                        

                    
@if(Auth::user()->hasrole('Admin'))
 
@else 
  <script>window.location = "/dashboard";</script>
@endif
    <?php 
    $data=App\Http\Controllers\Admin\AdminAccountDetailsController::globalSettings();
    ?>
    <div class="row">
    
     

      <div class="col-lg-12">
        <form action="{{route('account-details.update',$data->id)}}" method="POST">
          @csrf
          @method('PUT')      
          <div class="row">
     
      
      <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
                 <div class="col-lg-12">
            
      <div class="row">
					<div class="col-sm-6">
					   <label for="account">Bank Name</label>
					  <input type="text" class="form-control" name="bank_name" value="{{$data->bank_name}}" placeholder="" />
					</div>
					<div class="col-sm-6">
					  <label for="account">Account Title</label>
					  <input type="text" class="form-control" name="account_title" value="{{$data->account_title}}" placeholder="" />
					</div>
			</div>
        <hr>
        
        <div class="row">
					<div class="col-sm-6">
					   <label for="account">Account Number</label>
					  <input type="text" class="form-control" name="account_number" value="{{$data->account_number}}" placeholder="" />
					</div>
					<div class="col-sm-6">
					  <label for="account">Account IBAN</label>
					  <input type="text" class="form-control" name="account_iban" value="{{$data->account_iban}}" placeholder="" />
					</div>
			</div>
      <div class="row">
					<div class="col-sm-12">
					   <label for="account">WhatsApp ( E.g 923000000000)</label>
					  <input type="text" class="form-control" name="whats_app" value="{{$data->whats_app}}" placeholder="E.g 923000000000" />
					</div>
					<!-- <div class="col-sm-6">
					  <label for="account">Account Title</label>
					  <input type="text" class="form-control" name="account_title" value="{{$data->account_title}}" placeholder="" />
					</div> -->
			</div>
        
        <hr>
        <div class="row">
					<div class="col-sm-6">
					   <label for="account">EasyPaisa (Name)*</label>
					  <input type="text" class="form-control" name="easypaisa_name" value="{{$data->easypaisa_name}}" placeholder="" />
					</div>
					<div class="col-sm-6">
					  <label for="account">EasyPaisa (Acc#)*</label>
					  <input type="text" class="form-control" name="easypaisa_account" value="{{$data->easypaisa_account}}" placeholder="" />
					</div>
			</div>
        <hr>
        <div class="row">
					<div class="col-sm-6">
					   <label for="account">JazzCash (Name)*</label>
					  <input type="text" class="form-control" name="jazzcash_name" value="{{$data->jazzcash_name}}" placeholder="" />
					</div>
					<div class="col-sm-6">
					  <label for="account">JazzCash (Acc#)*</label>
					  <input type="text" class="form-control" name="jazzcash_account" value="{{$data->jazzcash_account}}" placeholder="" />
					</div>
			</div>
        <hr>
        
        <button type="submit" class="btn btn-light btn-lg col-md-12">Save changes</button>
       

          </div>
        </div>
      
      </div>
    </div>
  
          </form>
        </div>
      
      </div>
      
    </div>
  </div>
</section>
	</div>
</div>

@endsection