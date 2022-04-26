@extends('layouts.backend.backend')
@push('styles')
  {{--  <link rel="stylesheet" src="{{asset('summernote/summernote.min.css"')}}">  --}}
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css" integrity="sha256-SMGbWcp5wJOVXYlZJyAXqoVWaE/vgFA5xfrH3i/jVw0=" crossorigin="anonymous" />
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Permissions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Show</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      <div class="container-fluid">
       
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
                <b>{{ $user->first_name." ".$user->last_name }} Information</b>
            </h3>
          </div>
          <div class="card-body">
           
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Role Name</label>
                               <input type="input" name="name" value="{{$user->first_name }}"  class="form-control" style="width: 100%;" disabled  >
                        </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Second Name</label>
                             <input type="input" name="display_name" value="{{$user->second_name }}"  class="form-control" style="width: 100%;"  disabled >                          
                      </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Last Name</label>
                               <input type="input" name="description" value="{{$user->last_name }}"  class="form-control" style="width: 100%;" disabled >                          
                        </div>
                    </div>  

                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Gender</label>
                               <input type="input" name="description" value="{{$user->gender }}"  class="form-control" style="width: 100%;" disabled >                          
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Email</label>
                               <input type="input" name="description" value="{{$user->email }}"  class="form-control" style="width: 100%;" disabled >                          
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Phone Number</label>
                               <input type="input" name="description" value="{{$user->phone_number }}"  class="form-control" style="width: 100%;" disabled >                          
                        </div>
                    </div> 
                    
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Email Verified On</label>
                               <input type="input" name="description"  class="form-control" style="width: 100%;" disabled 
                                @if($user->email_verified_at!=NULL)
                                 value = "{{$user->email_verified_at->diffForHumans()}}"
                                @else    
                                 value = "Not Verified"
                                @endif
                               >                          
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Account Created On</label>
                               <input type="input" name="description"  class="form-control" style="width: 100%;" disabled 
                                @if($user->email_verified_at!=NULL)
                                 value = "{{$user->email_verified_at->diffForHumans()}}"
                                @else    
                                 value = "Not Verified"
                                @endif
                               >                          
                        </div>
                    </div> 
                    
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Is user permitted to uses system?</label>
                               <input type="input" name="description"   class="form-control" style="width: 100%;" disabled 
                                @if($user->isBan == 0)
                                 value = "Is Permitted"
                                @else
                                 value = "Not Permitted" 
                                @endif 
                               >                          
                        </div>
                    </div>

                   
                    
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>User Roles</label>
                          @if($user->roles->count() > 0)                        
                           @foreach($user->roles as  $index=>$role)
                              <p><ul><li>{{ $role->display_name }}</li></ul></p>      
                           @endforeach
                          @else
                            <p>User does not have any roles</p>
                          @endif   
                                                   
                        </div>
                    </div> 

                    
                </div>

               
            </form>
         
          </div>
        </div>
      </div><!-- /.container-fluid -->
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{ asset('js/app.js') }}" async defer></script>


@endpush