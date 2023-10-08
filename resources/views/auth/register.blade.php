

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css
" rel="stylesheet">


<script src="assets/layouts/Auth/js/jquery.min.js"></script>
  <script src="assets/layouts/Auth/js/popper.js"></script>
  <script src="assets/layouts/Auth/js/bootstrap.min.js"></script>
  <script src="assets/layouts/Auth/js/main.js"></script>
	<title>Sign Up</title>
</head>
<body>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->


<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/layouts/Auth/css/style.css">


<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-12 col-lg-10">
						<div class="wrap d-md-flex">
							<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
							  
							  

							  	
							<div class="text w-100">
									<h2>Welcome to Future Secure  Sales & Marketing</h2>
									<p>Haven't login yet?Don't worry just fill all the information below and get account now</p>
									<a href="/login" class="btn btn-white btn-outline-white">Login account</a>
								</div>
							</div>
							<div class="login-wrap p-4 p-lg-5">
							
							    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
										<div class="alert alert-danger" role="alert">
                                            {{ $error }}
										</div>
                                        @endforeach
                                @endif
								<div class="d-flex">
								
									<div class="w-100">
										<h3 class="mb-4">Sign Up</h3>
									</div>
									<div class="w-100">
										<p class="social-media d-flex justify-content-end">
											<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
											<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
										</p>
									</div>
								</div>

								<div>
								<form method="POST" action="{{ route('register') }}" class="signin-form">
                                @csrf
									<div class="container">
										<div class="row">
										    
													
											<div class="col-md-6 col-12">
												<div class="form-group mb-3">
													<label class="label" for="name">User Name</label>
													<input type="text" id="name" name="name" class="form-control" placeholder="Name"  />
												</div>
											</div>
													

											
											<div class="col-md-6 col-12">
												<div class="form-group mb-3">
													<label class="label" for="full_name">Full Name</label>
													<input  type="text" name="full_name" id="full_name" class="form-control" placeholder="Full Name" required />
												</div>
											</div>
										</div>
										</div>
									<div class="container">
										<div class="row">
											<div class="col-md-6 col-12">
												<div class="form-group mb-3">
													<label class="label" for="name">Father Name</label>
													<input type="text" name="father_name" class="form-control" placeholder="Father  Name" />
												</div>
											</div>
											<div class="col-md-6 col-12">
												<div class="form-group mb-3">
													<label class="label" for="name">CNIC No</label>
													<input type="text" name="cnic" class="form-control" placeholder="CNIC NO"  />
												</div>
											</div>
										</div>
									</div>
										
										<div class="container">
										<div class="row">
											<div class="col-md-6 col-12">
												<div class="form-group mb-3">
													<label class="label" for="name">Email</label>
													<input  type="email" name="email" class="form-control" placeholder="Email" required />
												</div>
											</div>
																							
											<div class="col-md-6 col-12">
												<div class="form-group mb-3">
													<label class="label" for="name">Referral Username</label>
													<?php 
													    if(isset($_REQUEST['refral_name'])){
														
														?>
														  
                                                          <input type="text" onclick="checkRef(this.value)" readonly  id="refral_name" value="{{$_REQUEST['refral_name']}}" name="refral_name" required  class="bg-light form-control" placeholder="Referral Name"  />
														   <script>
															$(document).ready(function(){
                                                                checkRef('<?=$_REQUEST['refral_name']?>');
                                                              });
														  
														   </script>
														<?php
														
														}else{
														?>
                                                          <input type="text" id="refral_name" name="refral_name" required onchange="checkRef(this.value)" class="form-control" placeholder="Referral Name"  />
														<?php

														}
													?>
													
												</div>
											</div>
										
										</div>
										</div>	

										<div class="container">
										<div class="row">

										<div class="col-md-6 col-12">
												<div class="form-group mb-3">
												<label class="label" for="password">Password</label>
									            <input type="password" name="password" class="form-control" placeholder="Password" required>
												</div>
											</div>
										<div class="col-md-6 col-12">
									      <div class="form-group mb-3">
										    <label class="label" for="password">Confirm Password</label>
									         <input type="password" name="password_confirmation" class="form-control" placeholder="Password" required>
									        </div>

											</div>
											
												
										  </div>
										  </div>
									    </div>
                                        <input type="hidden" name="refral_id" value="" id="refral_id">
									<br />
									<div class="form-group">
										<button type="submit" class="form-control btn btn-primary submit px-3">Create Account</button>
									</div>
									<div class="form-group d-md-flex">
										<div class="w-50 text-left"></div>
										<div class="w-50 text-md-right">
											<a href="#">Forgot Password</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		

 
  
   <script>
	   
															
   
	   function checkRef(name){
		$("#refral_id").val(null);
		$("#refral_name").val(null);
		$.ajax({
		url: "/checkRefral",
		type: "POST",
		headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),   
        },
		data:{
			name:name,
		},
		cache: false,
		success: function(dataResult){
			if(dataResult.data==null){
				// swal("Oops!", "User Not Found!", "error")
				Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong!',
        footer: '<a href>Refral User Not Found?</a>'
    })
			}else{
				$("#refral_id").val(dataResult.data.id);
                $("#refral_name").val(dataResult.data.name);
			}
           
			
		}
	    });
	   }
   </script>
	
</body>
</html>


 

