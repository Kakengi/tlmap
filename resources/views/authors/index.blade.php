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
                    <h1>Authors</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Authors</li>
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
                                    <a href="{{ route('authors.create') }}" class="btn btn-outline-primary btn-sm float-right" style="margin-left: 4%;">
                                        <i class="fa fa-plus"></i>
                                        New Authors</a>
                                </div>
                                <h3 class="card-title">List of authors</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <form method="GET" action="{{ route('authors.index') }}">
                                    <div class="col-md-12">
                                        <div class="row form-group">
                                            <div class="col-md-6">
                                                <input name="name" class="form-control form-control-sm" placeholder="Author's Name or Abbreviated Name ..." value="{{ request()->get('name') ? request()->get('name') : old('name') }}" />
                                            </div>
                                            <div class="col-md-3">
                                                <div class="btn-group">
                                                    @if(request('name'))
                                                    <a href="{{ route('authors.index') }}" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-times"></i> Cancel</a>
                                                    @endif
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-filter"></i> Filter
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                                @if($search)
                                <div class="row">
                                    <div class="alert border-primary border-1 col-md-12">
                                        <span class="text-primary">Found total number of {{ $authors->total() }} record(s) matching your criteria</span>
                                    </div>
                                </div>
                                @endif
                                <hr />

                                <div class="dataTables_length float-left">
                                    <form action="{{ route('authors.index', $_GET) }}" method="GET">
                                        <label>Showing
                                            <select class="" name="per_page" id="page-length">
                                                <option value="10" {{ request()->get('per_page') == 10 ? 'selected' : '' }}>10
                                                </option>
                                                <option value="20" {{ request()->get('per_page') == 20 ? 'selected' : '' }}>20
                                                </option>
                                                <option value="50" {{ request()->get('per_page') == 50 ? 'selected' : '' }}>50
                                                </option>
                                                <option value="100" {{ request()->get('per_page') == 100 ? 'selected' : '' }}>100
                                                </option>
                                            </select>
                                            Entries
                                        </label>
                                    </form>
                                </div>

                                <div class="float-right">
                                    {{ $authors->appends($_GET)->links() }}
                                </div>

                                <table class="table table-striped table-hover yajra-datatable">
                                    <thead>
                                        <tr class="bg-primary text-sm">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th width="10%">Short Name</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($authors as $item)
                                        <tr class="text-sm">
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->short_name }}</td>
                                            <td>{{ optional($item->user)->last_name }}</td>
                                            <td>{{ $item->created_at->diffForHumans() }}</td>
                                            <td class="text-center">
                                                @include('actions.actions' , [
                                                'btn_show_type' => 'btn-outline-success',
                                                'btn_edit_type' => 'btn-outline-primary',
                                                'btn_delete_type' => 'btn-outline-danger',
                                                'btn_right_space' => 'mr-2',
                                                'btn_show' => false,
                                                'btn_edit' => true,
                                                'btn_delete' => true,
                                                'show_link' => route('authors.show' , $item->id),
                                                'edit_link' => route('authors.edit' , $item->id),
                                                'delete_link' => route('authors.destroy' ,$item->id)
                                                ])
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9">
                                                <span class="text-danger">No records found.</span>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <div class="float-left">
                                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                        Showing
                                        {{ ($authors->currentPage() - 1) * $authors->perPage() + 1 }}
                                        to
                                        {{ ($authors->currentPage() - 1) * $authors->perPage() + count($authors) }}
                                        of
                                        {{ $authors->total() }}
                                        entries
                                    </div>
                                </div>
                                <div class="float-right">
                                    {{ $authors->appends($_GET)->links() }}
                                </div>

                            </div>
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
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ajax_request.js') }}"></script>
<script type="text/javascript">
    $(function() {


        $('.select2-class').select2({
            theme: 'classic'
            , placeholder: 'Select Class ...'
            , clear: true
        , });

        $('.select2-subject').select2({
            theme: 'classic'
            , placeholder: 'Select Subject ...'
            , clear: true
        , });

        $('.select2-book-category').select2({
            theme: 'classic'
            , placeholder: 'Select Book Category ...'
            , clear: true
        , });


        $('#contract-year').on('change', function() {
            var year = $(this).val();
            var current_url = window.location.pathname;
            window.location.href = current_url + "?contract_year=" + year;
        })

        var selected_school_type_id = $("#school-type").val();
        var url = "{{ route('ajax.get_school_classes') }}"

        if (selected_school_type_id) {
            // var selected_school_class_id = "{{ json_encode(request()->get('school_class_id')) }}";
            url = url + "?" + window.location.href.split('?')[1];
            var data = {
                school_type_id: selected_school_type_id
            , }
            ajaxRequest(url, data, 'JSON', 'GET', getResponse)
        }

        $('#school-type').on('change', function() {
            var school_type_id = $(this).val()

            var data = {
                school_type_id: school_type_id
            }
            ajaxRequest(url, data, 'JSON', 'GET', getResponse)
        })

        function getResponse(res) {
            $("#school-class").html(res.data)
        }
    });

</script>
@endpush
