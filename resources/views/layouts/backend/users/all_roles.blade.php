@extends('layouts.backend.backend')
@push('styles')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">  
  
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
              <li class="breadcrumb-item active">Roles</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      <div class="container-fluid">
       <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                    <div class="form-group">
                        <a href="{{ route('roles.create') }}" class="btn btn-success float-right">Add Role</a>

                    </div>
                  <h3 class="card-title">All System Roles Are Available Below</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="datatable" class="table table-bordered table-hover datatable">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Role Name</th>
                      <th>Display Name</th>
                      <th>Role Description</th>
                      <th>Action</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $index=>$role)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>{{ $role->description }}</td>
                            
                            <td width="">
                                {{--  <form action = "{{ route('roles.destroy',$role->id) }}"  enctype="multipart/form-data" method="POST">  --}}
                                      {{csrf_field()}}
                                      {{ method_field('DELETE') }}

                                      <a title="View Role" class="btn btn-xs btn-primary" href="{{ route('roles.show',$role->id) }}" >
                                        <i class="fa fa-info"></i>
                                      </a> 
                                     
                                        <a title="Edit User" class="btn btn-xs btn-success" href="{{ route('roles.edit',$role->id) }}" >
                                            <i class="fa fa-edit"></i>
                                        </a>      
                                 
                                      <button type="submit" class="btn btn-xs btn-danger"  title="Delete User" title="Destroy" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fa fa-trash" aria-hidden="true"></i>

                                      </button>
                                  
                                      
                                      
                                   
                                {{--  </form>  --}}
                                
                            </td>
                          </tr>

                          <!-- Delete Modal -->
                          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                            <form action="{{ route('roles.destroy',$role->id) }}" method="POST">
                                @csrf
                                @method('delete')
              
                             <div class="modal-content">
                               <div class="modal-header">
                                 
                                 <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                                 </button>
                               </div>
                               <div class="modal-body">
                                 Click Delete button to delete the data.
                               </div>
                               <div class="modal-footer">
                                 {{--  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  --}}
                                 <button type="submit" class="btn btn-danger">Delete</button>
                               </div>
                             </div>
                            </form>
                           </div>
                          </div>  
                        @endforeach
                    
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th>Display Name</th>
                        <th>Role Description</th>
                        <th>Action</th>
                      
                    </tfoot>
                  </table>
                </div>
                {{--  <div class="card-footer">
                  <div class="float-right">
                    {{ $roles->links() }}
                  </div>
                </div>  --}}
                <!-- /.card-body -->
              </div>

              
       </div>  
     
        <!-- /.card -->

      <!-- /.container-fluid -->
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection

@push('scripts')
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
  $(document).ready( function () {
      $('#datatable').DataTable();
  });
</script>
@endpush