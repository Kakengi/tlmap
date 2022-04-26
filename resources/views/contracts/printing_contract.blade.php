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
                    <h1>Contract Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('contracts.index') }}">Contracts</a></li>
                        <li class="breadcrumb-item active">Details</li>
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

                                <h3 class="card-title text-primary"><i class="fa fa-list"></i> Contracts Details List
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <select name="contract_id" id="contract" class="form-control form-control-sm">
                                                @foreach($contracts as $key => $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $contract->id ? 'selected=selected' : ''  }}>
                                                    {{ Illuminate\Support\Str::upper($item->contract_title) }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <hr />
                                    <fieldset>
                                        <legend>
                                            <h3 class="h5">Contract Details Form</h3>
                                        </legend>
                                        <form method="POST" action="{{ isset($edit) ? route('publication_contract.update' , [$eContractDetails->contract_id , $eContractDetails->id]) : route('publication_contract.store' , $contract->id) }}">
                                            @csrf
                                            @isset($edit)
                                            @method('PUT')
                                            @endisset
                                            <input type="hidden" name="contract_id" value="{{ $contract->id }}" />
                                            <input type="hidden" value="{{ request()->get('contract_year') }}" name="contract_year" />
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <label for="publication">Publication</label>
                                                    <div class="form-group">
                                                        <select name="publication_id" id="publication" class="form-control form-control-sm @error('publication_id') is-invalid @enderror">
                                                            <option value="">Select Publication...</option>
                                                            @foreach ($publications as $item)
                                                            <option value="{{ $item->id }}" {{ (isset($edit) && $eContractDetails->publication_id == $item->id) || (old('publication_id') == $item->id) ? 'selected=selected' : '' }}>
                                                                {{ $item->publication_title }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('publication_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="quantity">Quantity</label>
                                                    <div class="form-group">
                                                        <input id="quantity" type="number" min="1" name="quantity" class="form-control form-control-sm @error('quantity') is-invalid @enderror" placeholder="Quantity ..." value="{{ isset($edit) ? $eContractDetails->quantity : old('quantity') }}" />
                                                        @error('quantity')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label>{{ __("") }} <br /></label>
                                                    <div class="form-group">
                                                        <label class="ml-3">
                                                            <input name="is_for_sale" type="checkbox" {{ isset($edit) && $eContractDetails->is_for_sale || old('is_for_sale') ? 'checked' : '' }} /> For Sale
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>{{ __("") }} <br /></label>
                                                    <div class="form-group">
                                                        @if (isset($edit))
                                                        <a class="btn btn-sm btn-danger" href="{{ route('contracts.show' , $eContractDetails->contract_id ) }}">
                                                            <i class="fa fa-times"></i> Cancel
                                                        </a>
                                                        @endif
                                                        <button type="submit" class="btn btn-sm btn-success float-left">
                                                            <i class="fa fa-save"></i> {{ isset($edit) ? __('Update') : __('Save') }}
                                                        </button>
                                                        @if(!isset($edit))
                                                        <button type="reset" class="btn btn-sm btn-danger float-right">
                                                            <i class="fa fa-times"></i> Reset
                                                        </button>
                                                        @endif

                                                    </div>

                                                </div>

                                            </div>
                                        </form>
                                    </fieldset>

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
                                    {{-- {{ $contracts->appends($_GET)->links() }} --}}
                                </div>
                                <table class="table table-striped  table-condensed">
                                    <thead class="bg-warning text-sm">
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>For Sale</th>
                                            <th>Quantity</th>
                                            <th>CreatedAt</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($contract->publication as $index => $item)
                                        <tr class="text-sm {{ $item->deleted_at ? 'text-danger' : '' }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                {{ optional($item->book)->title }}
                                                {!! $item->is_large_print ? __(' <span class="font-weight-bold">LARGE PRINT</span>') : '' !!}
                                            </td>
                                            <td>{{ $item->pivot->is_for_sale ? __('Yes') : __('No') }}</td>
                                            <td>
                                                {{ number_format( $item->pivot->quantity) }}
                                            </td>
                                            <td title="{{ $item->pivot->created_at }}">
                                                {{ $item->pivot->created_at->diffForHumans() }}
                                            </td>
                                            <td class="text-right">
                                                @include('actions.actions' , [
                                                'btn_show_type' => 'btn-outline-success',
                                                'btn_edit_type' => 'btn-outline-primary',
                                                'btn_delete_type' => 'btn-outline-danger',
                                                'btn_right_space' => 'mr-2',
                                                'is_deleted' => $item->deleted_at,
                                                'btn_show' => false,
                                                'btn_edit' => isset($edit) && $item->pivot->id == $eContractDetails->id ? false : true ,
                                                'btn_delete' => true,
                                                'btn_restore' => true,
                                                'show_link' => route('contracts.show' , $contract->id),
                                                'edit_link' => route('publication_contract.edit' , [$contract->id , $item->pivot->id ]),
                                                'delete_link' => route('contracts.destroy' ,$item->pivot->id),
                                                'restore_link' => route('contracts.restore' , $item->pivot->id)
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
                                        <tr>
                                            <td colspan="3">
                                                <span class="float-right font-weight-bold">Total</span>
                                            </td>
                                            <td>{{ number_format($contract->publication->sum('pivot.quantity')) }}</td>
                                            <td colsapn="2"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <div class="float-left">
                                    {{-- <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                Showing
                                {{ ($contracts->currentPage() - 1) * $contracts->perPage() + 1 }}
                                    to
                                    {{ ($contracts->currentPage() - 1) * $contracts->perPage() + count($contracts) }}
                                    of
                                    {{ $contracts->total() }}
                                    entries
                                </div> --}}
                            </div>
                            <div class="float-right">
                                {{-- {{ $contracts->appends($_GET)->links() }} --}}
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
        $('#contract').select2({
            theme: 'classic'
            , placeholder: 'Select Contract ...'
            , clear: true
        , });

        $('#publication').select2({
            theme: 'classic'
            , placeholder: 'Select Publication ...'
            , clear: true
        , });

        $('#page-length').on('change', function() {
            var url = $(this).closest('form').attr('action')
            var per_page = $(this).val();
            url = url.includes('?') ? url + "&per_page=" + per_page : url +
                "?per_page=" + per_page;
            window.location.href = url
        })

        $('#contract').on('change', function() {
            var contract_id = $(this).val();
            var url = "{{ route('contracts.show' , ':id') }}";
            window.location.href = url.replace(":id", contract_id);
        })



        $('#publication').on('change', function() {
            var publication_id = $(this).val()
            var url = "{{ route('ajax.aggregated_num_of_books') }}"
            var data = {
                publication_id: publication_id
            }
            ajaxRequest(url, data, 'JSON', 'GET', getResponse)
        })

        function getResponse(res) {
            if (res) {
                $("input[name=quantity]").val(res)
                $("input[name=quantity]").attr("max", res)
            } else {
                $("input[name=quantity]").val("")
            }

        }
    });

</script>
@endpush
