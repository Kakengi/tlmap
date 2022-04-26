@extends('layouts.backend.backend')
@push('styles')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<style>
    .select2-search__field {
        width: 100% !important;
        /* height: 15px; */
    }

</style>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Schools Books Requirements</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Schools books requirements</li>
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

                                <h3 class="card-title text-primary">List of schools with number of students/pupils and
                                    number of books
                                    required
                                    by
                                    class , subject and year of study
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="GET" action="{{ route('school_requirements.index') }}">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <select name="year" class="form-control form-control-sm">
                                                    <option value="">Select Year ... </option>
                                                    @for ($i = date('Y'); $i >= 2020; $i--)
                                                    <option value="{{ $i }}" {{ request()->get('year') == $i ? 'selected=selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input name="school_name" class="form-control form-control-sm" placeholder="School Name ..." value="{{ request()->get('school_name') ? request()->get('school_name') : old('school_name') }}" />
                                            </div>
                                            <div class="col-md-2">
                                                <select name="school_type_id" id="school-type" class="form-control form-control-sm">
                                                    <option value="">Type of School ...</option>
                                                    @foreach ($schoolTypes as $item)
                                                    <option value="{{ $item->id }}" {{ request()->get('school_type_id') == $item->id ? 'selected=selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="school_class_id[]" id="school-class" multiple class="form-control form-control-sm select2-class">
                                                </select>
                                                @if (request()->get('per_page'))
                                                <input type="hidden" value="{{ request()->get('per_page') }}" name="per_page" />
                                                @endif
                                            </div>

                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <select name="subject_id[]" multiple class="form-control form-control-sm select2-subject">
                                                    <option value="">Select Subject ...</option>
                                                    @foreach ($subjects as $item)
                                                    <option value="{{ $item->id }}" {{ is_array(request()->get('subject_id')) && in_array($item->id, request()->get('subject_id'))? 'selected=selected': '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="btn-group">
                                                    @if (request()->get('school_name') || request()->get('school_type_id') || (is_array(request()->get('subject_id')) && count(request()->get('subject_id'))) > 0)
                                                    <a class="btn btn-sm btn-danger" href="{{ route('school_requirements.index', ['year' => $year]) }}">
                                                        <i class="fa fa-times"></i> Clear
                                                    </a>
                                                    @endif

                                                    <button type="submit" class="btn btn-sm btn-secondary">
                                                        <i class="fa fa-filter"></i> Filter
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr />
                                @if ($schoolObject)
                                <div class="alert border border-primary">
                                    <p class="text-secondary font-weight-bold">Total
                                        number of students/Pupils Books Required
                                        {{ number_format($schoolObject->total_required_books) }}
                                        for the year {{ $year }}
                                    </p>
                                </div>
                                @endif
                                <div class="dataTables_length float-left">
                                    <form action="{{ route('school_requirements.index', $_GET) }}" method="GET">
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
                                    {{ $schoolRequirements->appends($_GET)->links() }}
                                </div>
                                <table class="table table-striped  table-condensed">
                                    <thead class="bg-secondary text-sm">
                                        <tr>
                                            <th>Sn.</th>
                                            <th>School Name</th>
                                            <th>Region</th>
                                            <th>District</th>
                                            <th>Ward</th>
                                            <th>Reg#</th>
                                            <th>Year</th>
                                            <th>Class</th>
                                            <th>Subject</th>
                                            <th># Students</th>
                                            <th class="text-cente"># Books Required</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($schoolRequirements as $item)
                                        <tr class="text-sm">
                                            <td>{{ $item->id }}</td>
                                            <td>{{ optional($item->school)->name }}</td>
                                            <td>{{ $item->region_name }}</td>
                                            <td>{{ $item->district_name }}</td>
                                            <td>{{ $item->ward_name }}</td>
                                            <td></td>
                                            <td>{{ $item->year_of_study }}</td>
                                            <td>{{ optional($item->schoolClass)->name }}</td>
                                            <td>{{ optional($item->subject)->name }}</td>
                                            <td class="text-center">{{ $item->num_students }}</td>
                                            <td class="text-center"> {{ $item->required_books }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11">
                                                <span class="text-danger">No records for the year
                                                    {{ $year }}</span>
                                            </td>
                                        </tr>
                                        @endforelse
                                        @if ($schoolObject)
                                        <tr class="text-secondary font-weight-bold bg-secondary">
                                            <td colspan="10" class="text-right">Total Number of Students/Pupils Books </td>
                                            {{-- <td class="text-center">
                                                {{ $schoolObject ? number_format($schoolObject->total_num_students) : '' }}
                                            </td> --}}
                                            <td class="text-center">
                                                {{ $schoolObject ? number_format($schoolObject->total_required_books) : '' }}
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <div class="float-left">
                                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                        Showing
                                        {{ ($schoolRequirements->currentPage() - 1) * $schoolRequirements->perPage() + 1 }}
                                        to
                                        {{ ($schoolRequirements->currentPage() - 1) * $schoolRequirements->perPage() + count($schoolRequirements) }}
                                        of
                                        {{ $schoolRequirements->total() }}
                                        entries
                                    </div>
                                </div>
                                <div class="float-right">
                                    {{ $schoolRequirements->appends($_GET)->links() }}
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>



                    <!-- /.container-fluid -->
                </div>
    </section>
    <!-- /.content -->
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('js/ajax_request.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
    $(function() {

        $('.select2-class').select2({
            theme: 'classic'
            , placeholder: 'Select Classes ...'
            , clear: true
        , });

        $('.select2-subject').select2({
            theme: 'classic'
            , placeholder: 'Select Subjects ...'
            , clear: true
        , });

        $('#page-length').on('change', function() {
            var url = $(this).closest('form').attr('action')
            var per_page = $(this).val();
            url = url.includes('?') ? url + "&per_page=" + per_page : url +
                "?per_page=" + per_page;
            window.location.href = url
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
