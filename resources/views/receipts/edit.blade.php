@extends('layouts.backend.backend')
@push('styles')
  {{--  <link rel="stylesheet" src="{{asset('summernote/summernote.min.css"')}}">  --}}
  {{--  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    --}}
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contract and Supplier Informatation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Contract and Supplier Informatation</li>
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
            <h3 class="card-title">
              {{ $supplies_information->contract->supplier->name }} Information
            </h3>
            
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form class="form" action="{{ route('receipts.update',$supplies_information->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Name</label>
                        <input type="text"  class="form-control"   value="{{ $supplies_information->contract->supplier->name }}" disabled>                   
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Address</label>
                        <input type="text"  class="form-control"   value="{{ $supplies_information->contract->supplier->address }}" disabled>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Phone Number</label>
                        <input type="text"  class="form-control"   value="{{$supplies_information->contract->supplier->phone_number }}" disabled>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Region</label>
                        <input type="text"  class="form-control"   value="{{ $supplies_information->contract->supplier->region->name }}"  disabled>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>District</label>
                        <input type="text"  class="form-control"   value="{{ $supplies_information->contract->supplier->district->name }}" disabled>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Email</label>
                        <input type="text"  class="form-control"   value="{{ $supplies_information->contract->supplier->address }}" disabled>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Contract Number</label>
                        <input type="text"  class="form-control"   value="{{ $supplies_information->contract->contract_number }}" disabled>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Book Category</label>
                        <input type="text"  class="form-control"   value="{{ $supplies_information->contract->contract_number }}" disabled>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Book Type</label>
                        <input type="text"  class="form-control"    @if ($supplies_information->is_for_sale == 0) value="Not for sale" @elseif($supplies_information->is_for_sale == 1) value="For sale" @else value="" @endif  disabled>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Book Quantity Per Contract</label>
                        <input type="text"  class="form-control"   value="{{ number_format($supplies_information->contract->quantity) }}" disabled>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Contract Year</label>
                        <input type="text"  class="form-control"   value="{{ $supplies_information->contract->contract_year }}" disabled>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Expected Delivery Date</label>
                        <input type="text"  class="form-control"   value="{{ $supplies_information->contract->delivery_date }}" disabled>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Books Box Supplied</label>
                        <input type="number" name="box_quantity"  class="form-control"   value="{{ $supplies_information->box_quantity }}" min="1" >                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Books Per Box Supplied</label>
                        <input type="number" name="quantity_per_box"  class="form-control"   value="{{ $supplies_information->quantity_per_box }}" min="1" >                     
                    </div>
                  </div>
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Books Per Box Supplied</label>
                      <select id="gross_weight" name="gross_weight" class="form-control @error('gross_weight') is-invalid @enderror" value="{{ old('gross_weight') }}">
                        <option value="">Select Boxes Gross Weight</option>
                        @for( $i=1.0; $i<=1000.0; $i++ )
                            <option @if($i  == $supplies_information->gross_weight) selected='selected' @endif  value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Updated By</label>
                        <input type="text" name=""  class="form-control"   value="{{ auth()->user()->first_name." ". auth()->user()->last_name }}" min="1" disabled>                     
                    </div>
                  </div>
                  
                </div>  
                
                <div class="card-footer">
                    <div class="form-actions">
                        <a href="{{ route('receipts.index') }}" type="reset" class="btn btn-warning mr-1 float-left">
                            <i class="feather icon-x"></i> Cancel
                        </a>

                        <button  type="submit" class="btn btn-success mr-1 float-right">
                            <i class="feather icon-x"></i> Update Supplies Information
                        </button>
                       
                    </div>
                  </div>
            </form>
          </div>

                
         
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


@endpush