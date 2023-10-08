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
            <li class="breadcrumb-item"><a href="#">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
          </ol>
        </nav>
      </div>
      <div class="col-6">
        <div class="d-flex justify-content-end">
          <!-- <a href="{{route('User.edit',$data->id)}}" class="btn btn-secondary">Edit Profile</a> -->
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


    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3"></h5>
            <p class="text-muted mb-1">{{$data->name}}</p>
            <p class="text-muted mb-4">{{$data->user_type}}</p>
            <div class="d-flex justify-content-center mb-2">
            </div>
          </div>
        </div>
      
      </div>
     

      <div class="col-lg-8">
        <form action="{{route('User.update',$data->id)}}" method="POST">
          @csrf
          @method('PUT')      
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="form-group mb-4">
                 <label for="name">Name</label>
                  <input type="text" class="form-control text-dark" readonly value="{{$data->name}}" name="name" id="name" placeholder="name">
                </div>
            </div>
            <hr>
            <div class="row">
              <div class="form-group mb-4">
                 <label for="full_name">Full Name</label>
                  <input type="text" class="form-control" value="{{$data->full_name}}" name="full_name" id="full_name" placeholder="name">
                </div>
            </div>
            <hr>
            <div class="row">
              <div class="form-group mb-4">
                 <label for="email">email</label>
                  <input type="text" class="form-control text-dark" readonly value="{{$data->email}}" name="email" id="email" placeholder="email">
                </div>
            </div>
            <hr>
            <div class="row">
              <div class="form-group mb-4">
                 <label for="father_name">father Name</label>
                  <input type="text" class="form-control" value="{{$data->father_name}}" name="father_name" id="father_name" placeholder="father_name">
                </div>
            </div>
            <hr>
            <div class="row">
              <div class="form-group mb-4">
                 <label for="cnic">cnic</label>
                  <input type="text" class="form-control" value="{{$data->cnic}}" name="cnic" id="cnic" placeholder="cnic">
                </div>
            </div>
            <hr>
			  <button type="submit" class="btn btn-light btn-lg col-md-12 mt-3">Save changes</button>

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