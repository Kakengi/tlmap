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
                <b>{{ $role->name}} Information</b>
            </h3>
          </div>
          <div class="card-body">
           
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label>Role Name</label>
                               <input type="input" name="name" value="{{$role->name }}"  class="form-control" style="width: 100%;" disabled  >
                        </div>
                    </div>
                </div>
           
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                        <h3>Permissions</h3>
                          @if($role->permissions->count() > 0) 
                            <div class="row">                       
                                @foreach($role->permissions as  $index=>$role)
                                    <p><ul><li>{{ $role->display_name }}</li></ul></p>      
                                @endforeach
                            </div>
                          @else
                            <p>User does not have any permission</p>
                          @endif   
                    </div>
                    
                  </div>
                    {{-- <div class="form-group">
                      <label>Roles Permission Attachments</label>
                      @if($role->permissions->count() > 0)                        
                        @foreach($role->permissions as  $index=>$role)
                          <p><ul><li>{{ $role->display_name }}</li></ul></p>      
                        @endforeach
                      @else
                        <p>User does not have any roles</p>
                      @endif   
                                                
                    </div> --}}
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