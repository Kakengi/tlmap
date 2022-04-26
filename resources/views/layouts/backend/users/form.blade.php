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
            <h1>
              {{ isset($edit) ? __('Edit User') : 'Create new User' }}
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
              <li class="breadcrumb-item active">{{ isset($edit) ? __('Edit') : __('Create') }}</li>
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
               {{ isset($edit) ? 'Edit '.$editedUser->first_name.' '.$editedUser->second_name.' '.$editedUser->last_name : 'Create User'  }}
            </h3>
           
            <form class="form" action="{{isset($edit) ? route('users.update',$editedUser->id) : route('users.store')}}" method="POST">
              @csrf
              @if(isset($edit))
                @method('PUT')
              @endif

             <div class="btn-group float-right">
               @if (isset($edit))
                   <a class="float-right btn btn-success mr-2 ml-2" href="{{ route('users.create') }}">
                    <i class="fa fa-plus"></i>
                    Add new User</a>
               @endif
                <button type="submit" class="btn btn-primary float-right">
                <i class="fa fa-check-square-o"></i> {{ isset($edit) ? 'Update' : 'Save'  }}
              </button>
               
             </div>
          </div>
          <div class="card-body">
           
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>First Name</label>
                            <input type="input" name="first_name" value="{{ isset($edit) ? $editedUser->first_name : old('first_name')}}"  class="form-control @error('first_name') is-invalid @enderror" style="width: 100%;" required placeholder="Enter First Name ...">
                        </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Second Name</label>
                        <input type="input" name="second_name" value="{{isset($edit) ? $editedUser->second_name: old('second_name') }}"  class="form-control @error('second_name') is-invalid @enderror" style="width: 100%;" required placeholder="Enter Middle Name ..." >                           
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="input" name="last_name" value="{{ isset($edit) ? $editedUser->last_name : old('last_name') }}"  class="form-control @error('last_name') is-invalid @enderror" style="width: 100%;" required placeholder="Enter Last Name ...">     
                      </div>
                  </div>

                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Email</label>
                           @if(isset($edit))
                             <input type="email" name="email" value="{{ isset($edit) ? $editedUser->email : '' }}"  class="form-control @error('email') is-invalid @enderror" style="width: 100%;" required placeholder="Enter an Email" disabled>
                           @else
                             <input type="email" name="email" value=""  class="form-control @error('email') is-invalid @enderror" style="width: 100%;" required placeholder="Enter an Email">  
                           @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Gender</label>
                           @if(isset($edit))
                            <input type="phone" name="sex" value="{{ isset($edit) ? $editedUser->sex : ''}}"  class="form-control @error('sex') is-invalid @enderror" style="width: 100%;" required placeholder="" disabled>
                           @else
                           <select id="projectinput5" name="sex" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                           </select>   
                           @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Phone Number</label>
                           @if(isset($edit))
                             <input type="phone" name="phone_number" value="{{ isset($edit) ? $editedUser->phone_number : ''}}"  class="form-control @error('phone_number') is-invalid @enderror" style="width: 100%;" required placeholder="Enter an phone number" disabled>
                           @else
                             <input type="phone" name="phone_number" value=""  class="form-control @error('phone_number') is-invalid @enderror" style="width: 100%;" required placeholder="Ex 07837890xx" >
                           @endif
                        </div>
                    </div>

    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="projectinput5">Verification Status:</label>
                            <select  name="email_verified_at" class="form-control @error('email_verified_at') is-invalid @enderror" disabled>
                                  
                                      @if(isset($edit))
                                            @if($editedUser->email_verified_at == NULL)
                                            <option value="not_verified" 
                                                @if($editedUser->email_verified_at == NULL)
                                                    selected
                                                @endif
                                                
                                               
                                            >Not Verified</option>
                                            <option value="verify">Verify</option>
                                            
                                            @else
                                            <option value="verified"
                                            @if($editedUser->email_verified_at != NULL)
                                            selected
                                            @endif
                                            >Verified</option>  
                                            <option value="un_verify">Un-Verify</option>
                                            @endif
                                      @endif  
                                      <option value="{{ $current_verified_at }}">Verify</option>
                                      <option value="un-verified">Un-Verify</option>     
                                   
                            </select>
                            @error('email_verified_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                      </div>


                      <div class="col-md-12">
                        <div class="form-group">
                            <label for="projectinput5">Ban/Unban User:</label>
                            <select id="projectinput5" name="isBan" class="form-control @error('isBan') is-invalid @enderror" disabled>
                                  
                                      @if(isset($edit))
                                            @if($editedUser->isBan == 1)
                                            <option value=1 
                                                @if($editedUser->isBan == 1)
                                                    selected
                                                @endif
                                                
                                               
                                            >User Is Banned</option>
                                            <option value=0>Unban</option>
                                            
                                            @else
                                            <option value=0
                                            @if($editedUser->isban != 1)
                                            selected
                                            @endif
                                            >User is Unbanned</option>  
                                            <option value=1>Ban User</option>
                                            @endif
                                        @else
                                         <option value=0>Unban User</option>
                                         <option value=1>Ban User</option>     

                                      @endif  
                                   
                            </select>
                            @error('isBan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                      </div>


                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="checkbox" name=""   id="renew_password"  onchange="rewNewPassword()">
                          @if(isset($edit))
                              <label for="renew_password">Renew Password?</label>
                          @else
                              <label for="renew_password">Make Password?</label> 
                          @endif
                      </div>
                  </div>

                  <div class="col-md-12" id="password" style="display: none;">
                    <div class="form-group">
                      <label>Password</label>
                         <input type="password" name="password" id="text_field"   class="form-control @error('password') is-invalid @enderror" style="width: 100%;"  placeholder="Update Password">
                         @error('password')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                         @enderror
                    </div>
                  </div>

                  <div class="col-md-4" id="roles" >
                      <div class="form-group">
                        <label>Roles</label>
                        <select class="js-example-basic-multiple form-control" name="roles[]" multiple="multiple" >
                          @foreach($roles as  $role)
                            <option value="{{ $role->id }}"
                              {{ isset($edit) && in_array($role->name , $editedUser->getRoles()) ? 'selected=selected'  : '' }}
                              >{{ $role->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div> 
                </div>

              

                <div class="card-footer">
                    <div class="form-actions">
                        <button type="reset" class="btn btn-warning mr-1 float-left">
                            <i class="feather icon-x" ></i> Cancel
                           
                        </button>
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-check-square-o"></i> 
                                  {{ isset($edit) ? 'Update' : 'Save' }}                             
                        </button>
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

<script>
 // $('#fullName').css('display','none'); // Hide the text input box in default
function rewNewPassword() {
   if($('#renew_password').prop('checked')) {
         $('#password').css('display','block');
         $('#text_field').attr('required', '');
         $('#text_field').attr('data-error', 'This field is required.');
       } else {
         $('#password').css('display','none');
         $('#text_field').removeAttr('required', '');
         $('#text_field').removeAttr('data-error', 'This field is required.');
       }
}
</script>

<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
      theme : 'classic',
      placeholder : 'Roles ...'
    });
});
</script>
@endpush