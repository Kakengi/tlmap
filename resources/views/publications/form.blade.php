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
                    <h1>{{ isset($edit) ? __('Edit Publication') : __('New Publication') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('publications.index') }}">Publications</a></li>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-info">
                            {{ isset($edit) ? 'Edit '.$ePublication->title : 'Create Publication' }}
                        </h3>
                        {{-- <button type="submit" class="btn btn-primary btn-sm float-right">
                                {{ isset($edit) ? 'Update' : 'Save' }}
                        </button> --}}
                    </div>
                    <!-- /.card-header -->

                    <form class="form p-0 ml-4 mt-2" action="{{ route('publications.create') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <label>School Type</label>
                                <div class="form-group">
                                    <select name="school_type_id" id="school-type" class="form-control form-control-sm">
                                        <option value="">Type of School ...</option>
                                        @foreach ($schoolTypes as $item)
                                        <option value="{{ $item->id }}" {{ (isset($edit) &&  optional(optional($ePublication->book)->schoolClass)->school_type_id == $item->id) || request()->get('school_type_id') == $item->id ? 'selected=selected' : '' }}>

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
                                    </select>
                                    @if (request()->get('per_page'))
                                    <input type="hidden" value="{{ request()->get('per_page') }}" name="per_page" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <div class="form-group">
                                    <div class="btn-group">

                                        <button type="submit" class="btn btn-info btn-sm">
                                            <i class="fa fa-filter"></i> Filter Books
                                        </button>
                                        @if(request('school_type_id') || request('school_class_id'))
                                        <a href="{{ route('publications.create') }}" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> Clear</a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                    <hr class="p-0" />
                    <form class="form p-0" action="{{ isset($edit) ? route('publications.update', [$ePublication->id ,  'school_type_id' => request('school_type_id'), 'school_class_id' => request('school_class_id')]) : route('publications.store' , $_GET) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @if (isset($edit))
                        @method('PUT')
                        @endif

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <label>Select Book (Total Number of books {{ count($books) }}) </label>
                                    <div class="form-group">
                                        <select name="book_id" id="book" class="form-control form-control-sm @error('book_id') is-invalid @enderror">
                                            <option value="">Select Book ...</option>
                                            @foreach ($books as $item)
                                            <option data-title="{{ $item->title }}" value="{{ $item->id }}" {{ (isset($edit) && $ePublication->book_id == $item->id) || old('book_id') == $item->id ? 'selected=selected' : '' }}>
                                                {{ $item->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('book_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label><br /></label>
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" id="large-print-checkbox" name="is_large_print" {{ isset($edit) && $ePublication->is_large_print || old('is_large_print') ? 'checked' : ''  }} /> Is large print?
                                        </label>
                                        @error('is_large_print')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-9">
                                    <label for="publication-title">Publication Title </label>
                                    <div class="form-group">
                                        <input placeholder="Publication Title ..." name="publication_title" value="{{ isset($edit) ? $ePublication->publication_title : old('publication_title') }}" id="publication-title" class="form-control form-control-sm @error('publication_title') is-invalid @enderror" />
                                        @error('publication_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">

                                    <label>Author</label>
                                    <div class="form-group">
                                        <select name="author_id" id="author" class="form-control form-control-sm select2-author">
                                            <option value="">Select Author ...</option>
                                            @foreach ($authors as $item)
                                            <option value="{{ $item->id }}" {{ (isset($edit) && $ePublication->author_id == $item->id) || old('author_id') == $item->id ? 'selected=selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                            @endforeach

                                        </select>

                                        @error('author_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Number of Pages</label>
                                    <div class="form-group">
                                        <input value="{{ isset($edit) ? $ePublication->number_of_pages : old('number_of_pages') }}" type="number" name="number_of_pages" placeholder="Number of page" min="1" class="form-control form-control-sm  @error('number_of_pages') is-invalid @enderror" />
                                        @error('number_of_pages')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Year of Publication</label>
                                    <div class="form-group">
                                        <select name="publication_year" class="form-control form-control-sm  @error('publication_year') is-invalid @enderror">
                                            <option value="">Select Year ...</option>
                                            @for($year = date('Y') ; $year > 2015 ; $year--) <option value="{{ $year }}" {{ (isset($edit) && $ePublication->publication_year == $year) || (old('publication_year')==$year) ?'selected=selected' : ''   }}>
                                                {{ $year }}</option>
                                            @endfor
                                        </select>
                                        @error('publication_year')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Attachment</label>
                                    <div class="form-group">
                                        <input type="file" name="filename" id="book-title" value="{{ isset($edit) ? $ePublication->title : old('title') }}" placeholder="file" value="{{ isset($edit) ? $ePublication->address : old('title') }}">
                                        @error('filename')
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
                                <button type="reset" class="btn btn-info btn-sm float-left">
                                    <i class="feather icon-x"></i> Reset
                                </button>
                                @else
                                <a class="btn btn-sm btn-outline-info" href="{{ route('publications.create') }}">New Book</a>
                                @endif
                                <div class="float-right btn-group">
                                    <button type="submit" name="btn_action" value="save_edit" class="btn btn-info btn-sm mr-3">
                                        <i class="fa fa-check-square-o"></i>
                                        {{ isset($edit) ? 'Update & Edit' : 'Save & Edit' }}
                                    </button>

                                    <button type="submit" name="btn_action" value="save_exit" class="btn btn-outline-info btn-sm mr-3">
                                        <i class="fa fa-check-square-o"></i>
                                        {{ isset($edit) ? 'Update & Exit' : 'Save & Exit' }}
                                    </button>

                                    <button type="submit" name="btn_action" value="save_new" class="btn btn-info btn-sm">
                                        <i class="fa fa-check-square-o"></i>
                                        {{ isset($edit) ? 'Update & New' : 'Save & New' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


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
        $('#school-type').select2({
            theme: 'classic'
            , placeholder: 'Select Type ...'
            , clear: true
        , });
        $('#school-class').select2({
            theme: 'classic'
            , placeholder: 'Select Class ...'
            , clear: true
        , });

        $('#book').select2({
            theme: 'classic'
            , placeholder: 'Select Book ...'
            , clear: true
        , });

        $('.select2-author').select2({
            theme: 'classic'
            , placeholder: 'Select Author (Optional) ...'
            , clear: true
        , });

        $("#book").on("change", function() {

            var book_title = $("#book option:selected").data('title')
            var is_large_print = $("#large-print-checkbox").prop("checked")
            $("#publication-title").val(book_title + (is_large_print ? ' Large Print' : ''))
        })

        $("#large-print-checkbox").on("change", function() {
            var checked = $(this).prop('checked')
            var book_title = $("#book option:selected").data('title')
            $("#publication-title").val(book_title + (checked ? ' Large Print' : ''))

        })


    });

</script>
@include('scripts.classes_script')
@endpush
