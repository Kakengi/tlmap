@if($supplier->deleted_at != NULL)
<a title="Un-Delete User" class="btn btn-xs btn-outline-secondary ml-2" href="{{ route('supplier.undelete',$supplier->id) }}">
    <i class="fa fa-undo"></i>
</a>
@else
<a title="Show User" class="btn btn-xs btn-primary" href="">
    <i class="fa fa-eye"></i>
</a>
<a title="Edit User" class="btn btn-xs btn-outline-success ml-2" href="{{ route('suppliers.edit',$supplier->id) }}"> <i class="fa fa-edit"></i> </a>

<a href="#" data-supplier_id="{{ $supplier->id }}" class="delete btn btn-xs btn-outline-danger ml-2" title="Delete User" data-toggle="modal" data-target="#exampleModal">
    <i class="fa fa-trash"></i>
</a>
@endif
