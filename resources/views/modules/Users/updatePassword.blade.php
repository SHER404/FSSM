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
                                        <li class="breadcrumb-item active" aria-current="page">Update Password</li>
                                    </ol>
                                </nav>
                            </div>
                            <!-- /BREADCRUMB -->
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

                            <!--- registration form start ---> 

                            <div class="col-lg-12 col-12  layout-spacing">
                                <div class="statbox widget box box-shadow">
                                    <div class="widget-header">                                
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                <h4>Update Password</h4>
                                            </div>
                                        </div>
                                    </div>
                                     
                                    <div class="widget-content widget-content-area">
                                        
                                    <form action="update-password" method="POST">
                                        @csrf 
                                        <input type="hidden" value="{{$user->id}}" name="user_id" id="">
                                            <div class="row p-4">
                                                <div class="col-12">
                                                <div class="form-group mb-4">
                                                <label for="name">User</label>
                                                <input type="text" class="form-control text-dark bg-light" readonly  value="{{$user->name}}">
                                            </div>
                                            <div class="row p-4">
                                                <div class="col-12">
                                                <div class="form-group mb-4">
                                                <label for="name">Old Password</label>
                                                <input type="text" class="form-control"  name="old_password" id="name" placeholder="Old Password">
                                            </div>

                                            
                                            <div class="form-group mb-4">
                                                <label for="email">New Password</label>
                                                <input type="password" class="form-control"  name="new_password"  placeholder="New Password ">
                                                
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