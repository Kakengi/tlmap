@if(isset($btn_restore) && isset($is_deleted))
<form action="{{ $restore_link }}" method="POST" class="m-0 p-0">
    @csrf
    @method('PUT')
    @if ($btn_restore)
    <button title="Restore" data-message="to restore this item ?" data-action="restore" class="btn-restore btn btn-xs btn-outline-secondary mr-1">
        <i class="fa fa-undo"></i>
    </button>
    @endif
</form>
@else
<form action="{{ $delete_link }}" method="POST">
    <div class="btn-group">
        @csrf
        @method("DELETE")
        @if ($btn_show)
        <a href="{{ $show_link }}" class="btn btn-xs {{ isset($btn_right_space) ? $btn_right_space : 'mr-1'  }} {{ isset($btn_show_type ) ? $btn_show_type : 'btn-link' }}">
            <i class="fa  {{ isset($show_icon) ? $show_icon : 'fa-eye' }}"></i>
        </a>
        @endif
        @if ($btn_edit)
        <a href="{{ $edit_link }}" class="btn btn-xs {{ isset($btn_right_space) ? $btn_right_space : 'mr-1'  }}   {{ isset($btn_edit_type ) ? $btn_edit_type : 'btn-link' }}">
            <i class=" fa {{ isset($edit_icon) ? $edit_icon : 'fa-edit' }}"></i>
        </a>
        @endif
        @if ($btn_delete)
        <button class="btn-delete btn btn-xs  mr-2 {{ isset($btn_delete_type ) ? $btn_delete_type : 'btn-link' }}">
            <i class="fa {{ isset($delete_icon) ? $elete_icon : 'fa-trash' }}"></i>
        </button>
        @endif
    </div>
</form>
@endif
