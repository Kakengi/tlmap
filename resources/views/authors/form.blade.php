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
                    <h1>{{ isset($edit) ? __('Edit Author') : __('New Author') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('authors.index') }}">Authors</a></li>
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
                <form class="form" action="{{ isset($edit) ? route('authors.update', $eAuthor->id) : route('authors.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        @csrf
                        @if (isset($edit))
                        @method('PUT')
                        @endif
                        <div class="card-header">
                            <h3 class="card-title text-primary">
                                {{ isset($edit) ? 'Edit '.$eAuthor->title : 'Create Author' }}
                            </h3>
                            {{-- <button type="submit" class="btn btn-primary btn-sm float-right">
                                {{ isset($edit) ? 'Update' : 'Save' }}
                            </button> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Name</label>
                                    <div class="form-group">
                                        <input value="{{ isset($edit) ? $eAuthor->name : old('name') }}" type="text" name="name" placeholder="Author's Name ..." class="form-control form-control-sm  @error('name') is-invalid @enderror" />
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Short Name (Abbreviation)</label>
                                    <div class="form-group">
                                        <input value="{{ isset($edit) ? $eAuthor->short_name : old('short_name') }}" type="text" name="short_name" placeholder="Shortened Name ...(Optional)" class="form-control form-control-sm  @error('short_name') is-invalid @enderror" />
                                        @error('short_name')
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
                                <button type="reset" class="btn btn-primary btn-sm float-left">
                                    <i class="feather icon-x"></i> Reset
                                </button>
                                @else
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('authors.create') }}">New Book</a>
                                @endif
                                <div class="float-right btn-group">
                                    <button type="submit" name="btn_action" value="save_edit" class="btn btn-primary btn-sm mr-3">
                                        <i class="fa fa-check-square-o"></i>
                                        {{ isset($edit) ? 'Update & Edit' : 'Save & Edit' }}
                                    </button>

                                    <button type="submit" name="btn_action" value="save_exit" class="btn btn-outline-primary btn-sm mr-3">
                                        <i class="fa fa-check-square-o"></i>
                                        {{ isset($edit) ? 'Update & Exit' : 'Save & Exit' }}
                                    </button>

                                    <button type="submit" name="btn_action" value="save_new" class="btn btn-primary btn-sm">
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


    });

</script>
@endpush
