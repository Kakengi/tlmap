@extends('layouts.backend.backend')
@push('styles')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<style>
    .invalid-feedback {
        display: block !important;
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
                    <h1>Contracts Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Contracts</li>
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

                                <h3 class="card-title text-primary">List of Contracts
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3 mb-4">
                                            <select name="year" id="contract-year" class="form-control form-control-sm">
                                                <option value="">Select Contract Year ... </option>
                                                @for ($i = date('Y'); $i >= 2020; $i--)
                                                <option value="{{ $i }}" {{ request()->get('contract_year') == $i ? 'selected=selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    @if (request()->get('contract_year'))
                                    <fieldset>
                                        <legend>
                                            <h3 class="h5 text-underlined">Contract Form</h3>
                                        </legend>
                                        <form method="POST" action="{{ isset($edit) ? route('contracts.update' , $eContract->id) : route('contracts.store') }}">
                                            @csrf
                                            @isset($edit)
                                            @method('PUT')
                                            @endisset
                                            <input type="hidden" value="{{ request()->get('contract_year') }}" name="contract_year" />
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <label for="contract-title"> Contact Title</label>
                                                    <div class="form-group">
                                                        <input name="contract_title" id="contract-title" class="form-control form-control-sm @error('contract_title') is-invalid @enderror" placeholder="Contract Title ..." value="{{ isset($edit) ? $eContract->contract_title : old('contract_title') }}" />
                                                        @error('contract_title')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label for="contract-number">Contract Number</label>
                                                    <div class="form-group">
                                                        <input id="contract-number" name="contract_number" class="form-control form-control-sm @error('contract_number') is-invalid @enderror" placeholder="Contract Number ..." value="{{ isset($edit) ? $eContract->contract_number : old('contract_number') }}" />
                                                        @error('contract_number')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="year-of-study">Year of Study</label>
                                                    <div class="form-group">
                                                        <select name="year_of_study" id="year-of-study" class="form-control form-control-sm @error('year_of_study') is-invalid @enderror">
                                                            <option value="">Select Year of Study ... </option>
                                                            @for ($i = date('Y'); $i >= 2020; $i--)
                                                            <option value=" {{ $i }}" {{ isset($edit) && $eContract->year_of_study == $i || (old('year_of_study') == $i) ? 'selected=selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                            @endfor
                                                        </select>
                                                        @error('year_of_study')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="suppliers">Supplier</label>
                                                    <div class="form-group">
                                                        <select name="supplier_id" id="suppliers" class="form-control form-control-sm @error('supplier_id') is-invalid @enderror">
                                                            <option value="">Select Supplier ...</option>
                                                            @foreach ($suppliers as $item)
                                                            <option value="{{ $item->id }}" {{ isset($edit) && $eContract->supplier_id == $item->id || (old('supplier_id') == $item->id) ? 'selected=selected' : '' }}>
                                                                {{ $item->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('supplier_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">

                                                    <div class="form-group">
                                                        <label for="delivery-date">Delivery Date</label>
                                                        <input autocomplete="off" id="delivery-date" name="delivery_date" class="date-range-picker form-control form-control-sm @error('delivery_date') is-invalid @enderror" placeholder="yyyy-mm-dd" value="{{ isset($edit) ? $eContract->delivery_date : old('delivery_date') }}" readonly />
                                                        @error('delivery_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-2">

                                                    <label>{{ __("") }}<br /></label>
                                                    <div class="form-group">

                                                        @if (isset($edit))
                                                        <a class="btn btn-sm btn-danger" href="{{ route('contracts.index') }}">
                                                            <i class="fa fa-times"></i> Cancel
                                                        </a>
                                                        @endif
                                                        <button type="submit" class="btn btn-sm btn-success float-right">
                                                            <i class="fa fa-save"></i> {{ isset($edit) ? __('Update') : __('Save') }}
                                                        </button>

                                                        @if(!isset($edit))
                                                        <button type="reset" class="mr-4 btn btn-sm btn-danger">
                                                            <i class="fa fa-times"></i> Reset
                                                        </button>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </fieldset>
                                    @endif
                                </div>
                                <hr />

                                <div class="dataTables_length float-left">
                                    <form action="{{ route('contracts.index', $_GET) }}" method="GET">
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
                                    {{ $contracts->appends($_GET)->links() }}
                                </div>
                                <table class="table table-striped  table-condensed">
                                    <thead class="bg-success text-sm">
                                        <tr>
                                            <th>Sn.</th>
                                            <th>Title</th>
                                            <th>Supplier</th>
                                            <th>Contract No.</th>
                                            <th>Quantity</th>
                                            <th>Year of Study</th>
                                            <th>Contract Year</th>
                                            <th>Delivery</th>
                                            <th>Status</th>
                                            <th>CreatedBy</th>
                                            <th>CreatedAt</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($contracts as $item)
                                        <tr class="text-sm {{ $item->deleted_at ? 'text-danger' : '' }}">
                                            <td>{{ $item->id }}</td>
                                            <td class="text-justify text-uppercase">{{ $item->contract_title }}</td>
                                            <td>{{ optional($item->supplier)->name }}</td>
                                            <td>{{ $item->contract_number }}</td>
                                            <td>
                                                {{ number_format($item->publication->sum('pivot.quantity'))  }}
                                            </td>
                                            <td>{{ $item->year_of_study }}</td>
                                            <td>{{ $item->contract_year }}</td>
                                            <td>{{ $item->delivery_date }}</td>
                                            <td>
                                                <span class="badge text-uppercase {{ $item->contract_status == 'active' ? 'badge-info':'badge-success' }}">{{ $item->contract_status }}</span>
                                            </td>
                                            <td>{{ optional($item->createdBy)->last_name }}</td>
                                            <td title="{{ $item->created_at }}">{{ $item->created_at->diffForHumans() }}</td>
                                            <td class="text-center">
                                                @include('actions.actions' , [
                                                'btn_show_type' => 'btn-link text-success',
                                                'btn_edit_type' => 'btn-link text-primary',
                                                'btn_delete_type' => 'btn-link text-danger',
                                                'btn_right_space' => 'mr-2',
                                                'is_deleted' => $item->deleted_at,
                                                'btn_show' => true,
                                                'btn_edit' => true,
                                                'btn_delete' => true,
                                                'btn_restore' => true,
                                                'show_icon' => 'fa-list',
                                                'show_link' => route('contracts.show' , $item->id),
                                                'edit_link' => route('contracts.edit' , [$item->id ,'contract_year' => $item->contract_year ]),
                                                'delete_link' => route('contracts.destroy' ,$item->id),
                                                'restore_link' => route('contracts.restore' , $item->id)
                                                ])

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11">
                                                <span class="text-danger">No records found
                                                </span>
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
                                        {{ ($contracts->currentPage() - 1) * $contracts->perPage() + 1 }}
                                        to
                                        {{ ($contracts->currentPage() - 1) * $contracts->perPage() + count($contracts) }}
                                        of
                                        {{ $contracts->total() }}
                                        entries
                                    </div>
                                </div>
                                <div class="float-right">
                                    {{ $contracts->appends($_GET)->links() }}
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

        $('#suppliers').select2({
            theme: 'classic'
            , placeholder: 'Select Supplier ...'
            , clear: true
        , });


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
    });

</script>
@endpush
