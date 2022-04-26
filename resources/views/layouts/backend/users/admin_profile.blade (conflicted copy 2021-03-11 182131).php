@extends('layouts.backend.backend')
@push('styles')
  {{--  <link rel="stylesheet" src="{{asset('summernote/summernote.min.css"')}}">  --}}
  
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Your Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            
            <div class="col-md-12">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Your Basic Informations</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Manage Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Change Profile Picture</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <form class="form-horizontal">
                            <div class="form-group row">
                              <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                              <div class="col-sm-10">
                                <input type="email" value="{{ $user->first_name ." ". $user->last_name }}" class="form-control" disabled>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                              <div class="col-sm-10">
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                              <div class="col-sm-10">
                                <input type="email" class="form-control" value="{{ $user->gender }}" disabled>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputExperience" class="col-sm-2 col-form-label">Phone Number</label>
                              <div class="col-sm-10">
                                <input type="email" class="form-control" value="{{ $user->phone_number }}" disabled>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputSkills" class="col-sm-2 col-form-label">Account Duration</label>
                              <div class="col-sm-10">
                                <input type="email" class="form-control" value="{{ $user->created_at->diffForHumans() }}" disabled>
                              </div>
                            </div>
                           
                          </form>
  
                      
  
         
                      <!-- /.post -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                        <form action="{{ route('users.update',$user->id) }}" method="POST">
                            @csrf
                           
                            @method('PUT')
                            <div class="form-group row">
                              <label for="inputExperience" class="col-sm-2 col-form-label">Phone Number</label>
                              <div class="col-sm-10">
                                <input type="phone" name="phone_number" class="form-control" value="" placeholder="Update Your Phone Number">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputSkills" class="col-sm-2 col-form-label">Password</label>
                              <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" value="" placeholder="Update Your Password">
                              </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                  <button type="submit" class="btn btn-success float-right">Update</button>
                                </div>
                              </div>
                           
                          </form>
                      
                    </div>
                    <!-- /.tab-pane -->
  
                    <div class="tab-pane" id="settings">
                      <form class="form-horizontal" action="{{ route('profile.picture',$user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                           
                        @method('PUT')
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Upload Your Profile Picture</label>
                          <div class="col-sm-10">
                            <input type="file" name="avatar" class="form-control">
                          </div>
                        </div>          
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-success float-right">Save Profile Picture</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
    <!-- /.content -->
  </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>

  
@endpush