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
            <h1>Roles</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Role Create / Update</li>
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
               {{ isset($role) ? 'Update Permission' : 'Create Permission'  }}
            </h3>
            <button type="submit" class="btn btn-primary float-right">
            <form class="form" action="{{isset($role) ? route('roles.update',$role->id) : route('roles.store')}}" method="POST">
              @csrf
              @if(isset($role))
              {{method_field('PUT')}}
              {{ csrf_field() }}
              @endif
                <i class="fa fa-check-square-o"></i> {{ isset($role) ? 'Update' : 'Save'  }}
            </button>
          </div>
          <div class="card-body">
           
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Role Name</label>
                               <input type="input" name="name" value="{{isset($role) ? $role->name : ''}}"  class="form-control" style="width: 100%;" required placeholder="Enter Role Name"  >
                        </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Display Name</label>
                             <input type="input" name="display_name" value="{{ isset($role) ? $role->display_name : ''  }}"  class="form-control" style="width: 100%;"  placeholder="Enter Dislay Name" >                          
                      </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Description</label>
                               <input type="input" name="description" value="{{ isset($role) ? $role->description : ''  }}"  class="form-control" style="width: 100%;"  placeholder="Enter Permission Description" >                          
                        </div>
                      </div>  
                </div>
               @if(isset($role))
               <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                     Assign Permissions
                  </h3>           
                </div>
                <div class="card-body">
                      <div class="form-check">
                        <div class="row">
                          @foreach($permissions as $key => $permission)
                            <div class="col-md-3">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->id }}"
                                @foreach($role->permissionz as $P)
                                 @if($permission->id == $P->id)
                                   checked
                                 @endif
                                @endforeach
                                
                                ><em>({{ $permission->display_name }})</em>
                              </label>
                            </div>
                          @endforeach
                        </div>
                          
                      </div>            
                </div>
              </div>


               @else
               <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                     Assign Permissions
                  </h3>           
                </div>
                <div class="card-body">
                      <div class="form-check">
                        <div class="row">
                          @foreach($permissions as $key => $permission)
                            <div class="col-md-3">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->id }}"><em>({{ $permission->display_name }})</em>
                              </label>
                            </div>
                          @endforeach
                        </div>
                          
                      </div>            
                </div>
              </div>
              

               @endif 
              
                

                <div class="card-footer">
                    <div class="form-actions">
                        <button type="reset" class="btn btn-warning mr-1 float-left">
                            <i class="feather icon-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-check-square-o"></i> 
                                  {{ isset($role) ? 'Update' : 'Save' }}                             
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


@endpush