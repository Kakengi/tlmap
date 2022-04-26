@extends('layouts.backend.backend')
@push('styles')

@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Distribution to LGAs</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Distribution to LGAs</li>
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

                                <h3 class="card-title text-primary">Distribution List (LGAs)
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <form action="{{ route('distribution_districts.index') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="year" id="year-of-study" class="year form-control form-control-sm">
                                                <option value="">Select Year of Study ... </option>
                                                @for ($i = date('Y'); $i >= 2020; $i--)
                                                <option value="{{ $i }}" {{ request()->get('year') == $i ? 'selected=selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="region_id" id="region" class="form-control form-control-sm">
                                                <option value="">Select Region ... </option>
                                                @foreach($regions as $region)
                                                <option data-region="{{ $region->name }}" value="{{ $region->id }}" {{ request()->get('region_id') == $region->id ? 'selected=selected' : '' }}>
                                                    {{ $region->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="district_id" id="district" class="form-control form-control-sm">
                                                <option value="">Select Region First ... </option>
                                            </select>
                                            @error('district_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-filter"></i> Filter
                                            </button>
                                            {{-- <button class="btn btn-sm btn-outline-info" type="reset">Clear</button> --}}
                                            @if (request('year') || request('region_id') || request('district_id'))
                                            <a href="{{ route('distribution_districts.index') }}" class="btn btn-outline-danger btn-sm float-right">
                                                <i class="fa fa-times"></i> Cancel</a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                                <hr />
                                @if (request('year') || isset($edit))

                                <fieldset>
                                    <legend>
                                        <h3 class="h5">
                                            Distribution Form
                                            <span class="text-primary text-uppercase">
                                                {{ $selected_district_name ? $selected_district_name : '' }}
                                                {{ $selected_district_name && $selected_region_name ? " - " : '' }}
                                                {{ $selected_region_name ? $selected_region_name : '' }}
                                            </span>
                                        </h3>
                                    </legend>

                                    <form method="POST" action="{{ isset($edit) ? route('distribution_districts.update' , $eDistributionDistrict->id) : route('distribution_districts.store') }}">
                                        @csrf
                                        @isset($edit)
                                        @method('PUT')
                                        @endisset
                                        <input type="hidden" value="{{ request()->get('year') }}" name="year_of_study" />
                                        {{-- <input type="hidden" value="{{ request()->get('district_id') }}" name="district_id" /> --}}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Contracts</label>
                                                <div class="form-group">
                                                    <select name="contract_id" id="contract" class="form-control form-control-sm">
                                                        <option value=""></option>
                                                        @foreach($contracts as $key => $item)
                                                        <option data-quantity="{{ number_format($item->quantity) }}" value="{{ $item->id }}" {{ (isset($edit) && $item->id == $eDistributionDistrict->contract_id) || old('contract_id') == $item->id  ? 'selected=selected' : ''  }}>
                                                            {{ Illuminate\Support\Str::upper($item->contract_title) }}
                                                            {{ $item->contract_number ? "(".$item->contract_number.")": "" }}
                                                            {{ $item->contract_year ? $item->contract_year: "" }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="publication">Publication</label>
                                                <div class="form-group">
                                                    <select name="publication_id" id="publication" class="form-control form-control-sm @error('publication_id') is-invalid @enderror">
                                                        <option value="">Select Publication...</option>
                                                    </select>
                                                    @error('publication_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="">Region</label>
                                                <div class="form-group">
                                                    <select name="region_id" class="region form-control form-control-sm">
                                                        <option value="">Select Region ... </option>
                                                        @foreach($regions as $region)
                                                        <option data-region="{{ $region->name }}" value="{{ $region->id }}" {{ isset($edit) && optional($eDistributionDistrict->district)->region_id == $region->id || ( old('region_id') == $region->id) ? 'selected=selected' : '' }}>
                                                            {{ $region->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <label for="">District</label>
                                                <div class="form-group">
                                                    <select name="district_id" class="district form-control form-control-sm">
                                                        <option value="">Select Region First ... </option>
                                                    </select>
                                                    @error('district_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                            </div>


                                        </div>

                                        <div class="row">

                                            @if(isset($edit) || request('district_id'))
                                            <div class="col-md-2">
                                                <label for="qty-per-box">Qty Per Box</label>
                                                <div class="form-group">
                                                    <input id="qty-per-box" type="number" min="1" name="quantity_per_box" class="form-control form-control-sm @error('quantity_per_box') is-invalid @enderror" placeholder="Quantity Per Box..." value="{{ isset($edit) ? $eDistributionDistrict->quantity_per_box : old('quantity_per_box') }}" />
                                                    @error('quantity_per_box')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="number-of-boxes"># of Boxes</label>
                                                <div class="form-group">
                                                    <input id="number-of-boxes" type="number" min="1" name="number_of_boxes" class="form-control form-control-sm @error('number_of_boxes') is-invalid @enderror" placeholder="Number of Boxes ..." value="{{ isset($edit) ? $eDistributionDistrict->number_of_boxes : old('number_of_boxes') }}" />
                                                    @error('number_of_boxes')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="loose">Loose</label>
                                                <div class="form-group">
                                                    <input id="loose" type="number" min="1" name="loose" class="form-control form-control-sm @error('loose') is-invalid @enderror" placeholder="Loose ..." value="{{ isset($edit) ? $eDistributionDistrict->loose : old('loose') }}" />
                                                    @error('loose')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <label>{{ __("") }} <br /></label>
                                                <div class="form-group">
                                                    @if (isset($edit))
                                                    <a class="btn btn-sm btn-danger" href="{{ route('distribution_districts.index') }}">
                                                        <i class="fa fa-times"></i> Cancel
                                                    </a>
                                                    @endif
                                                    <button type="submit" class="btn btn-sm btn-success  mr-2">
                                                        <i class="fa fa-save"></i> {{ isset($edit) ? __('Update') : __('Save') }}
                                                    </button>
                                                    @if(!isset($edit))
                                                    <button type="reset" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-times"></i> Reset
                                                    </button>
                                                    @endif

                                                </div>

                                            </div>
                                            @endif
                                            @if(!isset($edit))
                                            <div class="col-md-4">
                                                <label>{{ __("") }} <br /></label>
                                                <div class="form-group">
                                                    <button style="display:none" type="button" id="generate-button" disabled class="btn btn-outline-success btn-sm float-left">
                                                        Generate For All LGAs
                                                    </button>
                                                </div>
                                            </div>
                                            @endif

                                        </div>

                                    </form>
                                </fieldset>

                                @endif

                                <hr />
                                <div class="dataTables_length float-left">
                                    <form action="{{ route('distribution_districts.index', $_GET) }}" method="GET">
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
                                    {{ $lgas->appends($_GET)->links() }}
                                </div>
                                <table class="table table-striped  table-condensed">
                                    <thead class="bg-success text-sm">
                                        <tr>
                                            <th>Sn.</th>
                                            <th>Region</th>
                                            <th>District</th>
                                            <th>Publication</th>
                                            <th>Qty Required</th>
                                            <th>Qty per Box</th>
                                            <th># Boxes</th>
                                            <th>Loose</th>
                                            <th class="font-weight-bold">Total</th>
                                            <th>CreatedBy</th>
                                            <th>Status</th>
                                            <th>CreatedAt</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($lgas as $index => $item)
                                        <tr class="text-sm {{ $item->deleted_at ? 'text-danger' : '' }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-justify text-uppercase">
                                                {{ optional(optional($item->district)->region)->name }}
                                            </td>
                                            <td>{{ optional($item->district)->name }}</td>
                                            <td>
                                                {{ optional(optional($item->publication)->book)->title }}
                                                {!! optional($item->publication)->is_large_print ? "<span class='text-danger'>Large Print</span>" : "" !!}
                                            </td>
                                            <td class="font-weight-bold">
                                                {{ number_format($item->quantity_required)  }}
                                            </td>
                                            <td>
                                                {{ number_format($item->quantity_per_box)  }}
                                            </td>
                                            <td>
                                                {{ number_format($item->number_of_boxes ) }}
                                            </td>
                                            <td>
                                                {{ number_format($item->loose) }}
                                            </td>
                                            <td class="font-weight-bold">
                                                {{ number_format($item->quantity_per_box * $item->number_of_boxes + $item->loose )  }}
                                            </td>
                                            <td>{{ optional($item->createdBy)->last_name }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                {{ $item->created_at }}
                                            </td>
                                            <td class="text-center">
                                                @include('actions.actions' , [
                                                'btn_show_type' => 'btn-link text-success',
                                                'btn_edit_type' => 'btn-link text-primary',
                                                'btn_delete_type' => 'btn-link text-danger',
                                                'btn_right_space' => 'mr-2',
                                                'is_deleted' => $item->deleted_at,
                                                'btn_show' => false,
                                                'btn_edit' => true,
                                                'btn_delete' => true,
                                                'btn_restore' => false,
                                                'show_icon' => 'fa-list',
                                                'edit_link' => route('distribution_districts.edit' ,[$item->id , 'year' => $item->year_of_study ]),
                                                'delete_link' => route('distribution_districts.destroy' ,$item->id),
                                                ])
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="13">
                                                <span class="text-danger">No records found
                                                </span>
                                            </td>
                                        </tr>
                                        @endforelse
                                        @if(count($lgas) > 0)
                                        <tr>
                                            <td colspan="4"></td>
                                            <td class="font-weight-bold text-primary">{{ number_format($total_required_books) }}</td>


                                            <td colspan="3"></td>
                                            <td class="font-weight-bold text-primary">{{ number_format($total_distributed_books) }}</td>

                                            <td colspan="4"></td>
                                        </tr>

                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <div class="float-left">
                                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                        Showing
                                        {{ ($lgas->currentPage() - 1) * $lgas->perPage() + 1 }}
                                        to
                                        {{ ($lgas->currentPage() - 1) * $lgas->perPage() + count($lgas) }}
                                        of
                                        {{ $lgas->total() }}
                                        entries
                                    </div>
                                </div>
                                <div class="float-right">
                                    {{ $lgas->appends($_GET)->links() }}
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

        $('.region').select2({
            theme: 'classic'
            , placeholder: 'Select Region ...'
            , clear: true
        , });


        $('.district').select2({
            theme: 'classic'
            , placeholder: 'Select Region First ...'
            , clear: true
        , });




        var region = "{{ $selected_region_name }}"
        var district = "{{ $selected_district_name }}"
        var generate_btn_text = "";

        function getText(region, district) {
            if (district) {
                generate_btn_text = "Generate For " + region + " - " + district
            } else if (region) {
                generate_btn_text = "Generate For " + region
            } else {
                generate_btn_text = "Generate for the whole Country"
            }
            return generate_btn_text
        }

        $("#year-of-study").on("change", function() {
            window.history.pushState('', '', replaceUrl())
        })

        $(".region").on("change", function() {
            var quantity = $("#contract option:selected").data('quantity')
            $("#generate-button")
                .text(
                    getText(
                        $(".region option:selected").data("region")
                        , ""
                    ) + (quantity ? " (" + quantity + ")" : "")

                )

        })

        $(".district").on("change", function() {
            var quantity = $("#contract option:selected").data('quantity')
            $("#generate-button")
                .text(
                    getText(
                        $(".region option:selected").data("region")
                        , $(".district option:selected").data("district")
                    ) + (quantity ? " (" + quantity + ")" : "")

                )

        })






        var url = "{{ route('ajax.get_list_publications_received') }}"
        var selected_contract_id = $("#contract").val();
        if (selected_contract_id) {

            var contract_id = selected_contract_id;
            var publication_id = "{{ isset($edit) ? $eDistributionDistrict->publication_id : old('publication_id') }}"

            var data = {
                contract_id: contract_id
                , selected_publication_id: publication_id
                , year_of_study: "{{ request('year') }}"
                , is_for_sale: false
            }
            ajaxRequest(url, data, 'JSON', 'GET', getPublicationOptionsResponse)
        }


        $('#contract').on('change', function() {
            var contract_id = $(this).val()
            var quantity = $("#contract option:selected").data('quantity')
            if (quantity) {
                $("#generate-button")
                    .text(getText(region, district) + " (" + quantity + ")")
                    .prop('disabled', false)
                    .show()
                    .on("click", function() {
                        if (confirm("Are you sure you want to generate of LGAs for this contract?")) {
                            $("#generate-button").prop('disabled', true)
                            ajaxRequest("{{ route('ajax.store_bulk_lgas_data') }}", {
                                    contract_id: contract_id
                                    , year_of_study: "{{ request('year') }}"
                                    , region_id: $(".region").val()
                                    , district_id: $(".district").val()
                                , }
                                , "JSON"
                                , "POST"
                                , storeLGAsData)
                        }
                        return false;
                    });
            } else {
                $("#generate-button").text("Generate For All LGAs").prop('disabled', true);
            }
            var data = {
                contract_id: contract_id
                , year_of_study: "{{ request('year') }}"
                , is_for_sale: false
            }
            ajaxRequest(url, data, 'JSON', 'GET', getPublicationOptionsResponse)
        })

        function getPublicationOptionsResponse(res) {
            $('#publication').html(res);
        }

        function storeLGAsData(res) {
            if (res.success) {
                toastr.success(res.message);
                window.location.href = "{{ route('distribution_districts.index') }}"
            } else {
                toastr.error(res.message)
            }

        }

        $('#publication').on('change', function() {
            var publication_id = $(this).val()
            var url = "{{ route('ajax.aggregated_num_of_books') }}"
            var data = {
                publication_id: publication_id
                , district_id: $(".district").val()
            }
            ajaxRequest(url, data, 'JSON', 'GET', getQuantityResponse)
        })

        function getQuantityResponse(res) {
            console.log(res)
            if (res) {
                $("#quantity").val(res);
            } else {
                $("#quantity").val("");

            }
        }

        var selected_region_id = "{{ isset($edit) ? optional($eDistributionDistrict->district)->region_id : old('region_id') }}";
        var url = "{{ route('ajax.get_districts_by_region') }}"

        if (selected_region_id) {
            var selected_district_id = "{{ isset($edit) ? $eDistributionDistrict->district_id : old('district_id') }}"

            var data = {
                region_id: selected_region_id
                , district_id: selected_district_id
            }
            ajaxRequest(url, data, "JSON", "GET", ajaxDistrictResponse)

        }

        $('.region').on("change", function() {
            var region_id = $(this).val();
            var data = {
                region_id: region_id
            }
            ajaxRequest(url, data, "JSON", "GET", ajaxDistrictResponse)
        })

        function ajaxDistrictResponse(res) {
            $(".district").html(res);
        }

    });

</script>
@endpush
