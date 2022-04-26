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
            <h1>Suppliers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Create Supplier</li>
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
                {{ isset($supplier) ? 'Edit Supplier': 'Create Supplier'}}
            </h3>
            <button type="submit" class="btn btn-primary float-right">
            <form class="form" action="{{ isset($supplier) ? route('suppliers.update',$supplier->id)  :  route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($supplier))
                  @method('PUT')
                @endif
                
            </button>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
           
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Supplier Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"  placeholder="Provide Supplier Name" value="{{isset($supplier) ? $supplier->name: old('name') }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Supplier Phone Number</label>
                        <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"  placeholder="Provide Supplier Phone Number" value="{{isset($supplier) ? $supplier->phone_number: old('phone_number') }}">
                        @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Supplier Email Address</label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"  placeholder="Supplier Email Address" value="{{isset($supplier) ? $supplier->email: old('email') }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Supplier Address</label>
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"  placeholder="Supplier Address" value="{{isset($supplier) ? $supplier->address: old('address') }}">
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Region Name</label>
                        <select id="region_name" name="region_id" class="form-control @error('region_id') is-invalid @enderror" value="{{ old('region_id') }}">
                          <option value="#">Select Region Name</option>
                          @foreach($regions as $key => $region)
                              <option  @if(isset($supplier)) @if($region->id == $supplier->region_id) selected='selected' @endif @endif   value="{{ $region->id }}">{{ $region->name}}</option>
                          @endforeach
                        </select>
                        @error('region_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>District Name</label>
                        <select id="district_name" name="district_id" class="form-control @error('district_id') is-invalid @enderror" value="{{ old('district_id') }}">
                            @if(isset($supplier))
                            @foreach($region_districts as $key => $district)
                            <option @if($district->id == $supplier->district_id) selected='selected' @endif  value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach 
                          @endif   
                        </select>
                        @error('district_id')
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
                        <button type="reset" class="btn btn-warning mr-1 float-left">
                            <i class="feather icon-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-check-square-o"></i> 
                            {{ isset($asset) ?  'Update' : 'Save' }}
                            
                        </button>
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
<script>
    $(document).ready(function () {
    $('#region_name').on('change', function () {
    let id = $(this).val();
    $('#district_name').empty();
    $('#district_name').append(`<option value="0" disabled selected>Processing...</option>`);
    $.ajax({
    type: 'GET',
    url: '/getDistrictsId/' + id,
    success: function (response) {
    var response = JSON.parse(response);
    console.log(response);   
    $('#district_name').empty();
    $('#district_name').append(`<option value="0" disabled selected>Select Districts</option>`);
     response.forEach(element => {
        $('#district_name').append(`<option value="${element['id']}">${element['name']}</option>`);
        }); 
    }
});
});
});
</script>


<script>
    $(document).ready(function () {
    $('#district_name').on('change', function () {
    let id = $(this).val();
    $('#ward_id').empty();
    $('#ward_id').append(`<option value="0" disabled selected>Processing...</option>`);
    $.ajax({
    type: 'GET',
    url: '/getWards/' + id,
    success: function (response) {
    var response = JSON.parse(response);
    console.log(response);   
    $('#ward_id').empty();
    $('#ward_id').append(`<option value="0" disabled selected>Select Wards</option>`);
     response.forEach(element => {
        $('#ward_id').append(`<option value="${element['id']}">${element['name']}</option>`);
        }); 
    }
});
});
});
</script>

@endpush