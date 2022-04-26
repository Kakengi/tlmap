@extends('layouts.backend.backend')
@push('styles')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Supplier Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Supplier</li>
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
                                    <a href="{{ route('suppliers.create') }}" class="btn btn-outline-primary float-right" style="margin-left: 4%;">
                                        <i class="fa fa-plus"></i>
                                        Create Supplier</a>


                                </div>
                                <h3 class="card-title">List of all books suppliers</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-striped table-hover yajra-datatable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Supplier Name</th>
                                            <th>Supplier Phone Number</th>
                                            <th>Supplier Email</th>
                                            <th>Supplier Address</th>
                                            <th>Region Name</th>
                                            <th>District Name</th>
                                            <th>Created By</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Supplier Name</th>
                                            <th>Supplier Phone Number</th>
                                            <th>Supplier Email</th>
                                            <th>Supplier Address</th>
                                            <th>Region Name</th>
                                            <th>District Name</th>
                                            <th>Created By</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    {{-- <h3 class="card-title">List of all books suppliers</h3>  --}}
                </div>
                <!-- /.card-header -->
                <!-- Delete Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form method="POST" id="form-modal-delete">
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
                                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  --}}
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function() {

        var table = $('.yajra-datatable').DataTable({
            processing: true
            , serverSide: true
            , ajax: "{{ route('suppliers.index') }}"
            , columns: [{
                    data: 'id'
                    , name: 'id'
                }
                , {
                    data: 'name'
                    , name: 'name'
                }
                , {
                    data: 'phone_number'
                    , name: 'phone_number'
                }
                , {
                    data: 'email'
                    , name: 'email'
                }
                , {
                    data: 'address'
                    , name: 'address'
                }
                , {
                    data: 'region'
                    , name: 'region.name'
                }
                , {
                    data: 'district'
                    , name: 'district.name'
                }
                , {
                    data: 'user'
                    , name: 'user.name'
                }
                , {
                    data: 'action'
                    , name: 'action'
                    , orderable: true
                    , searchable: true
                }
            , ]
        });

        $(document).on('click', '.delete', function() {
            var supplier_id = $(this).data('supplier_id');
            var url = '{{ route("suppliers.destroy" , ":id" ) }}';
            var form = $('#form-modal-delete');
            form.attr('action', url.replace(':id', supplier_id));
        })

    });

</script>


@endpush
