@extends('layout.layout')

@section('content')

            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <div class="row layout-top-spacing">

                        <div class="middle-content container-xxl p-0">

                            <!-- BREADCRUMB -->
                            <div class="page-meta">
                                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/class-sections">Edit User</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Update User</li>
                                    </ol>
                                </nav>
                            </div>
                            <!-- /BREADCRUMB -->
                           
                            <!--- registration form start ---> 

                            <div class="col-lg-12 col-12  layout-spacing">
                                
                                <div class="statbox widget box box-shadow">
                                    <div class="widget-header">                                
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                <h4>Update User</h4>
                                            </div>
                                        </div>
                                    </div>
                                     
                                    <div class="widget-content widget-content-area">
                                        
                                    <form action="update-user" method="POST">
                                        @csrf 
                                        <input type="hidden" value="{{$user->id}}" name="user_id" id="">
                                           <div class="row p-4">
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

                                           </div>
                                            
                                            <div class="row p-4">
                                                <div class="col-12">
                                                <div class="form-group mb-4">
                                                <label for="name">User Name</label>
                                                <input type="text" required class="form-control" value="{{$user->name}}"  name="name" id="name" placeholder="User Name">
                                            </div>

                                            
                                            <div class="form-group mb-4">
                                                <label for="email">Full Name</label>
                                                <input type="text" required class="form-control" value="{{$user->full_name}}"  name="full_name"  placeholder="Full name">
                                                
                                            </div>

                                               

                                               
                                               
                                              </div>

                                                </div>
                                                
                                                <div class="col-12">
                                                <input type="submit" class="btn btn-primary">
                                                </div>

                                             </div>
                                            
                                            
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--- registration form end ---> 
                        
                        <!--- main divs ending start --->
                        </div>
                    </div>
                </div>
            </div>

@endsection            