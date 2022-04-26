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
                    <h1>Publications</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Publications</li>
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
                                    <a href="{{ route('publications.create') }}" class="btn btn-outline-info btn-sm float-right" style="margin-left: 4%;">
                                        <i class="fa fa-plus"></i>
                                        New Publication</a>
                                </div>
                                <h3 class="card-title">List of Publications</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <form method="GET" action="{{ route('publications.index') }}">
                                    <div class="col-md-12">
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <select name="school_type_id" id="school-type" class="form-control form-control-sm">
                                                    <option value="">Type of School ...</option>
                                                    @foreach ($schoolTypes as $item)
                                                    <option value="{{ $item->id }}" {{ request()->get('school_type_id') == $item->id ? 'selected=selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="school_class_id" id="school-class" class="form-control form-control-sm select2-class">
                                                </select>
                                                @if (request()->get('per_page'))
                                                <input type="hidden" value="{{ request()->get('per_page') }}" name="per_page" />
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <select name="subject_id" class="form-control form-control-sm select2-subject">
                                                    <option value="">Select Subject ...</option>
                                                    @foreach ($subjects as $item)
                                                    <option value="{{ $item->id }}" {{ request()->get('subject_id') == $item->id ? 'selected=selected': '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="book_category_id" class="form-control form-control-sm select2-book-category">
                                                    <option value="">Select Subject ...</option>
                                                    @foreach ($bookCategories as $item)
                                                    <option value="{{ $item->id }}" {{ request()->get('book_category_id') == $item->id ? 'selected=selected': '' }}>
                                                        {{ $item->name_sw }}
                                                        {{ $item->name_en ? "(".$item->name_en.")" : "" }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select name="publication_year" id="publication-year" class="form-control form-control-sm">
                                                        <option value="">Select Publication Year ...</option>
                                                        @for($year = date('Y') ; $year > 2015 ; $year--)
                                                        <option value="{{ $year }}" {{ request('publication_year') == $year  ?'selected=selected' : ''   }}>
                                                            {{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="large-print">
                                                        <input id="large-print" type="checkbox" class="" name="is_large_print" {{ request('is_large_print') ? 'checked' : '' }} /> Large Print
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="btn-group float-right">
                                                    @if(request('school_class_id') || request('subject_id') || request('book_category_id') || request('publication_year') || request('is_large_print'))
                                                    <a href="{{ route('publications.index') }}" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-times"></i> Cancel</a>
                                                    @endif
                                                    <button type="submit" class="btn btn-sm btn-info">
                                                        <i class="fa fa-filter"></i> Filter
                                                    </button>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>

                                @if(request('school_class_id') || request('subject_id') || request('book_category_id'))
                                <div class="row">
                                    <div class="alert border-info border-1 col-md-12">
                                        <span class="text-info">Found total number of {{ $publications->total() }} record(s) matching your criteria</span>
                                    </div>
                                </div>
                                @endif
                                <hr />

                                <div class="dataTables_length float-left">
                                    <form action="{{ route('publications.index', $_GET) }}" method="GET">
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
                                    {{ $publications->appends($_GET)->links() }}
                                </div>

                                <table class="table table-striped table-hover yajra-datatable">
                                    <thead>
                                        <tr class="bg-info text-sm">
                                            <th>#</th>
                                            <th width="25%">Title</th>
                                            <th>Year</th>
                                            <th># of pages</th>
                                            <th title="Large print?">Large</th>
                                            <th>Author</th>
                                            <th>CreatedBy</th>
                                            <th>CreatedAt</th>
                                            <th>File</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($publications as $item)
                                        <tr class="text-sm">
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                {{ $item->publication_title }}
                                            </td>
                                            <td>{{ $item->publication_year }}</td>
                                            <td>{{ $item->number_of_pages }}</td>
                                            <td>
                                                <span class="badge {{ $item->is_large_print ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $item->is_large_print ? __('Yes') : __('No') }}
                                                </span>
                                            </td>
                                            <td>{{ optional($item->author)->name }}</td>
                                            <td>{{ optional($item->user)->last_name }}</td>
                                            <td>{{ $item->created_at->diffForHumans() }}</td>
                                            <td>
                                                @if($item->filename && file_exists(public_path('storage/books/'.$item->filename)))
                                                <a class="text-info" target="_blank" href="{{ route('download.publication' , $item->filename) }}">
                                                    <i class="fa fa-download"></i></a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @include('actions.actions' , [
                                                'btn_show_type' => 'btn-outline-success',
                                                'btn_edit_type' => 'btn-outline-primary',
                                                'btn_delete_type' => 'btn-outline-danger',
                                                'btn_right_space' => 'mr-2',
                                                'btn_show' => false,
                                                'btn_edit' => true,
                                                'btn_delete' => true,
                                                'show_link' => route('publications.show' , $item->id),
                                                'edit_link' => route('publications.edit' , [$item->id ,'school_type_id' => optional(optional($item->book)->schoolClass)->school_type_id , 'school_class_id' => optional($item->book)->school_class_id ]),
                                                'delete_link' => route('publications.destroy' ,$item->id)
                                                ])
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10">
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
                                        {{ ($publications->currentPage() - 1) * $publications->perPage() + 1 }}
                                        to
                                        {{ ($publications->currentPage() - 1) * $publications->perPage() + count($publications) }}
                                        of
                                        {{ $publications->total() }}
                                        entries
                                    </div>
                                </div>
                                <div class="float-right">
                                    {{ $publications->appends($_GET)->links() }}
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

        $('#school-type').select2({
            theme: 'classic'
            , placeholder: 'Select Type ...'
            , clear: true
        , });

        $('#publication-year').select2({
            theme: 'classic'
            , placeholder: 'Select Publication Year ...'
            , clear: true
        , });


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
