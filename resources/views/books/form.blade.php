@extends('layouts.backend.backend')
@push('styles')
<style>
    .invalid-feedback {
        display: block !important;
    }

</style>
@endpush
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($edit) ? __('Edit Book') : __('New Book') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Books</a></li>
                        <li class="breadcrumb-item active">{{ isset($edit) ? 'Edit' : 'Create' }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="container-fluid">
                <form class="form" action="{{ isset($edit) ? route('books.update', $eBook->id) : route('books.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        @csrf
                        @if (isset($edit))
                        @method('PUT')
                        @endif
                        <div class="card-header">
                            <h3 class="card-title text-secondary">
                                {{ isset($edit) ? 'Edit '.$eBook->title : 'Create Book' }}
                            </h3>
                            {{-- <button type="submit" class="btn btn-primary btn-sm float-right">
                                {{ isset($edit) ? 'Update' : 'Save' }}
                            </button> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Type of School </label>
                                        <select name="school_type_id" id="school-type" class="form-control form-control-sm">
                                            <option value="">Type of School ...</option>
                                            @foreach ($schoolTypes as $item)
                                            <option value="{{ $item->id }}" {{ isset($edit) && optional($eBook->schoolClass)->school_type_id == $item->id || (old('school_type_id') == $item->id) ? 'selected=selected' : '' }}>

                                                {{ $item->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">

                                    <label>Class</label>
                                    <div class="form-group">
                                        <select name="school_class_id" id="school-class" class="form-control form-control-sm select2-class">
                                            <option value="">Select Class ....</option>
                                        </select>
                                        @error('school_class_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label>Subject</label>
                                    <div class="form-group">
                                        <select name="subject_id" id="subject" class="form-control form-control-sm select2-subject">
                                            <option value="">Select Subject ...</option>
                                            @foreach ($subjects as $item)
                                            <option value="{{ $item->id }}" {{ (isset($edit) && $eBook->subject_id == $item->id ) || old('subject_id') == $item->id ? 'selected=selected': '' }}>
                                                {{ $item->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('subject_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label>Book Category</label>
                                    <div class="form-group">
                                        <select name="book_category_id" id="book-category" class="form-control form-control-sm select2-book-category">
                                            <option value="">Select Book Category ...</option>
                                            @foreach ($bookCategories as $item)
                                            <option value="{{ $item->id }}" {{ (isset($edit) && $eBook->book_category_id == $item->id) || (old('book_category_id') == $item->id) ? 'selected=selected': '' }}>
                                                {{ $item->name_sw }} {{ $item->name_en ? __("(".$item->name_en.")") : '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('book_category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Book Title</label>
                                    <div class="form-group">
                                        <input type="text" name="title" id="book-title" value="{{ isset($edit) ? $eBook->title : old('title') }}" class="form-control form-control-sm @error('title') is-invalid @enderror" placeholder="Book Title ...">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Number of Students/Pupils Per Book</label>
                                    <div class="form-group">
                                        <input type="Number" min="1" name="num_students_per_book" id="num-students-per-book" value="{{ isset($edit) ? $eBook->num_students_per_book : old('num_students_per_book') }}" class="form-control form-control-sm @error('num_students_per_book') is-invalid @enderror" placeholder="Number of Students Per Book...">
                                        @error('num_students_per_book')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Description</label>
                                    <div class="form-group">
                                        <textarea rows="4" name="description" placeholder="Enter Book Description ....(Optional)" class="form-control form-control-sm">{{ isset($edit) ? $eBook->description :old('description') }}</textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="form-actions">
                                @if (!isset($edit))
                                <button type="reset" class="btn btn-secondary btn-sm float-left">
                                    <i class="feather icon-x"></i> Reset
                                </button>
                                @else
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('books.create') }}">New Book</a>
                                @endif
                                <div class="float-right btn-group">
                                    <button type="submit" name="btn_action" value="save_edit" class="btn btn-secondary btn-sm mr-3">
                                        <i class="fa fa-check-square-o"></i>
                                        {{ isset($edit) ? 'Update & Edit' : 'Save & Edit' }}
                                    </button>

                                    <button type="submit" name="btn_action" value="save_exit" class="btn btn-outline-secondary btn-sm mr-3">
                                        <i class="fa fa-check-square-o"></i>
                                        {{ isset($edit) ? 'Update & Exit' : 'Save & Exit' }}
                                    </button>

                                    <button type="submit" name="btn_action" value="save_new" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-check-square-o"></i>
                                        {{ isset($edit) ? 'Update & New' : 'Save & New' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div><!-- /.container-fluid -->
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
        $('#suppliers').select2({
            theme: 'classic'
            , placeholder: 'Select Supplier ...'
            , clear: true
        , });

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
        $('.select2-book-category').select2({
            theme: 'classic'
            , placeholder: 'Select Book Category ...'
            , clear: true
        , });

        $("#book-category").on('change', function() {
            var book_title = $("#book-title")
            var school_class = $("#school-class option:selected")
            var subject = $("#subject option:selected")
            var book_category = $("#book-category option:selected")
            if (school_class.val() && subject.val() && book_category.val()) {
                var title = subject.text().trim() + " " + book_category.text().trim() + " " + school_class.text().trim();
                book_title.val(title.toUpperCase())
            }
        })

        $('#page-length').on('change', function() {
            var url = $(this).closest('form').attr('action')
            var per_page = $(this).val();
            url = url.includes('?') ? url + "&per_page=" + per_page : url +
                "?per_page=" + per_page;
            window.location.href = url
        })

        $('#contract-year').on('change', function() {
            var year = $(this).val();
            var current_url = window.location.pathname;
            window.location.href = current_url + "?contract_year=" + year;
        })

        var selected_school_type_id = $("#school-type").val();
        var url = "{{ route('ajax.get_school_classes') }}"

        if (selected_school_type_id) {
            // var selected_school_class_id = "{{ json_encode(request()->get('school_class_id')) }}";
            url = url + "?school_class_id={{ isset($edit) ? $eBook->school_class_id : old('school_class_id') }}";
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
