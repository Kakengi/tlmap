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
                    <h1>Books Received</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">supplies</li>
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

                                <h3 class="card-title text-primary">List of Supplies
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="col-md-12">
                                    <form action="{{ route('contract.information') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select name="contract_id" id="contract_id" class="form-control form-control-sm">
                                                    <option value="">Select Supplier Name ... </option>
                                                    @foreach($receipt_publication as $contracts)
                                                    <option value="{{ $contracts->contract_identifier }}">{{ $contracts->contract_number}} - ({{ $contracts->publication_title }}) - ({{ $contracts->contract_status }}) </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- ({{ $suppliers->publication->book->title }}) --}}
                                            <button type="submit" name="submit" class="btn btn-sm btn-info">
                                                <i class="fa fa-arrow-right"></i> Get Supplier Contract Informatation
                                            </button>
                                        </div>


                                    </form>

                                    {{-- @if (request()->get('contract_year'))  --}}
                                    <hr />
                                    @if(isset($_POST['submit']))
                                    <form  action="{{ route('receipts.store') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{isset($_POST['submit']) ? $contract_information->id : '' }}" name="contract_id" />
                                        {{-- <input type="hidden" value="{{isset($_POST['submit']) ?  $contract_information->is_for_sale  : ''}}" name="is_for_sale" /> --}}

                                        <div class="row mt-2">

                                            <div class="col-md-3">
                                                <label>Supplier Name</label>
                                                <input type="text" class="form-control form-control-sm" placeholder="Contract Number" value="{{isset($_POST['submit']) ? $contract_information->supplier->name : ''}}" disabled />
                                            </div>
                                            <div class="col-md-3">
                                                <label>Contract Number</label>
                                                <input type="text" class="form-control form-control-sm" placeholder="Contract Number" value="{{isset($_POST['submit']) ? $contract_information->contract_number : ''}}" disabled />
                                            </div>

                                            <div class="col-md-3">
                                                <label>Books Quantity Per Contract</label>
                                                <input type="text" class="form-control form-control-sm" placeholder="Books Quantity" value="{{isset($_POST['submit']) ? number_format($contract_information->quantity) : ''}}" disabled />
                                            </div>

                                            <div class="col-md-3">
                                                <label>Contract Status</label>
                                                <input type="text" class="form-control form-control-sm" value="{{isset($_POST['submit']) ? $contract_information->contract_status : ''}}" placeholder="Contract Status" disabled />
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            {{-- <div class="col-md-3">
                                                <label>Books Category</label>
                                                <input type="text"  class="form-control form-control-sm" value="{{isset($_POST['submit']) ? $contract_information->publication->book->title : ''}}" placeholder="Book Category" disabled/>
                                        </div> --}}
                                        <div class="col-md-3">
                                            <label>Supplier Phone Number</label>
                                            <input class="form-control form-control-sm" value="{{isset($_POST['submit']) ? $contract_information->supplier->phone_number : ''}}" placeholder="Books Type ..." disabled />
                                        </div>

                                        <div class="col-md-3">
                                            <label>Books Type</label>
                                            <input class="form-control form-control-sm" @if( isset($_POST['submit']) && $contract_information->is_for_sale == 0) value="Not for sale" @elseif( isset($_POST['submit']) && $contract_information->is_for_sale == 1) value="For sale" @else value="" @endif placeholder="Books Type ..." disabled />
                                        </div>

                                        <div class="col-md-3">
                                            <label>Contract Year</label>
                                            <input type="text" class="form-control form-control-sm" value="{{isset($_POST['submit']) ? $contract_information->contract_year : ''}}" placeholder="For sale box numbers" disabled />
                                        </div>

                                        <div class="col-md-3">
                                            <label>Box Quantity</label>
                                            <input type="number" name="number_of_boxes" class="form-control @error('number_of_boxes') is-invalid @enderror" value="" placeholder="Box Quantity" min="1" />
                                            @error('number_of_boxes')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                </div>


                                <div class="row mt-2">

                                    <div class="col-md-3">
                                        <label>Quantity Books Per Box</label>
                                        <input type="number" name="quantity_per_box" class="form-control @error('quantity_per_box') is-invalid @enderror" value="" placeholder="Books Quantity Per Box ..." min="1" />
                                        @error('quantity_per_box')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label>All Boxes Weight (Weight is in terms of Tons)</label>
                                        <select id="gross_weight" name="gross_weight" class="form-control @error('gross_weight') is-invalid @enderror" value="{{ old('gross_weight') }}">
                                            <option value="">Select Boxes Gross Weight</option>
                                            @for( $i=1.0; $i<=1000.0; $i++ ) 
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('gross_weight')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label>Received By</label>
                                        <input name="gross_weight" class="form-control form-control-sm" value="{{ auth()->user()->first_name." ".auth()->user()->first_name }}" placeholder="Gross Weight ..." disabled />
                                    </div>

                                    <div class="col-md-3" style="margin-top: 2%;">
                                        <div class="btn-group">
                                            {{-- @if (request()->get('school_name') || request()->get('school_type_id') || (is_array(request()->get('subject_id')) && count(request()->get('subject_id'))) > 0)
                                                    <a class="btn btn-sm btn-danger" href="{{ route('school_requirements.index', ['year' => $year]) }}">
                                            <i class="fa fa-times"></i> Clear
                                            </a>
                                            @endif --}}

                                            <button type="submit" class="btn btn-sm btn-info">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row mt-2">  --}}

                                {{-- </div>  --}}


                                </form>
                                {{-- @endif  --}}
                                @endif

                            </div>
                            <hr />


                            <div class="float-right">
                                {{-- {{ $contracts->appends($_GET)->links() }} --}}
                            </div>
                            <table class="table table-bordered table-striped  table-condensed">
                                <thead class="bg-info">
                                    <tr>
                                        <th>Sn.</th>
                                        <th class="text-center">Contract Number</th>
                                        <th class="text-center">Supplier Name</th>
                                        {{-- <th class="text-center">Book Name</th>  --}}
                                        <th class="text-center">Box Numbers</th>
                                        <th class="text-center">Books Per Box</th>
                                        <th class="text-center">Total Books</th>
                                        <th class="text-center">Books Quantity Per Contract</th>
                                        <th class="text-center">Remained Books</th>
                                        <th class="text-center">Gross Weight</th>
                                        <th class="text-center">Receiced By</th>
                                        <th class="text-center">Arrival Duration</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($receipts as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td class="text-center">{{ $item->contract->contract_number }}</td>
                                        <td class="text-center">{{ $item->contract->supplier->name }}</td>
                                        {{-- <td class="text-center">{{ $item->contract->publication->book->title }}</td> --}}
                                        <td class="text-center">{{ number_format($item->box_quantity) }}</td>
                                        <td class="text-center">{{ number_format($item->quantity_per_box) }}</td>
                                        <td class="text-center">{{ number_format($item->box_quantity * $item->quantity_per_box) }}</td>
                                        <td class="text-center">{{ number_format($item->contract->quantity) }}</td>
                                        <td class="text-center">

                                            {{ number_format($item->contract->quantity -  $item->box_quantity * $item->quantity_per_box)  }}</td>
                                        <td class="text-center">{{ $item->gross_weight }} Tons</td>
                                        <td class="text-center">{{ optional($item->user)->first_name." ". optional($item->user)->last_name }} </td>
                                        <td class="text-center">{{ $item->created_at->diffForHumans() }}</td>
                                        <td class="text-center">
                                            @include('actions.actions' , [
                                            'btn_show_type' => 'btn-outline-success',
                                            'btn_edit_type' => 'btn-outline-primary',
                                            'btn_delete_type' => 'btn-outline-danger',
                                            'btn_right_space' => 'mr-2',
                                            'btn_show' => true,
                                            'btn_edit' => true,
                                            'btn_delete' => true,
                                            'show_link' => route('receipts.show' , $item->id),
                                            'edit_link' => route('receipts.edit' , $item->id) ,
                                            'delete_link' => route('receipts.destroy' ,$item->id)
                                            ])
                                        </td>

                                        {{-- <td>{{ $item->year_of_study }}</td>
                                        <td>{{ optional($item->schoolClass)->name }}</td>
                                        <td>{{ optional($item->subject)->name }}</td>
                                        <td class="text-center">{{ $item->num_students }}</td>
                                        <td class="text-center"> {{ $item->required_books }}</td> --}}
                                    </tr>
                                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                ...
                                            </div>
                                        </div>
                                    </div>

                                    @empty
                                    <tr>
                                        <td colspan="13">
                                            <span class="text-danger center">No records found
                                            </span>
                                        </td>
                                    </tr>
                                    @endforelse
                                    @if($receipts->count() >0)
                                    <tr>
                                        <td colspan="4">Total Received</td>
                                        <td class="text-center"><b>{{ $total_box }}</b></td>
                                        <td class="text-center"><b>{{ number_format($total_books_box) }}</b></td>
                                        <td class="text-center"><b>48,000</b></td>
                                        <td class="text-center"><b>900,000</b></td>
                                        <td class="text-center"><b>500,000</b></td>
                                        <td class="text-center"><b>{{ $gross_weight }} Tons</b></td>
                                        <td colspan="3"></td>

                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="float-left">
                                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                    Showing
                                    {{ ($receipts->currentPage() - 1) * $receipts->perPage() + 1 }}
                                    to
                                    {{ ($receipts->currentPage() - 1) * $receipts->perPage() + count($receipts) }}
                                    of
                                    {{ $receipts->total() }}
                                    entries
                                </div>
                            </div>
                            <div class="float-right">
                                {{ $receipts->appends($_GET)->links() }}
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

@endpush
