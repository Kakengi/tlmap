<div class="btn-group">
    @if (!$user->deleted_at)
        <a title="Show User" class="btn btn-xs btn-outline-success mr-1" href="{{ route('users.show', $user->id) }}">
            <i class="fa fa-eye"></i>
        </a>
    @endif

    @if (!$user->deleted_at && !$user->is_ban)
        <a title="Edit User" class="btn btn-xs btn-outline-primary mr-1" href="{{ route('users.edit', $user->id) }}">
            <i class="fa fa-edit"></i>
        </a>
    @endif

    @if ($user->id !== auth()->id())
        @if (!$user->deleted_at && !$user->is_ban)
            <a href="#" data-user_id="{{ $user->id }}" class="delete btn btn-xs btn-outline-danger mr-1"
                data-action="delete" title="Delete User" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-trash"></i>
            </a>
        @endif
    @endif

    @if (!$user->deleted_at && $user->id !== auth()->id())
        <form action="{{ $user->is_ban ? route('unban.user', $user->id) : route('ban.user', $user->id) }}"
            method="POST" class="m-0 p-0">
            @csrf
            @method('PUT')
            <button type="submit" title="{{ $user->is_ban ? __('Revoke User Ban') : __('Ban this User') }}"
                data-message="{{ $user->is_ban ? ' to revoke this user ban ' : ' to ban this user ' }} {{ $user->first_name . ' ' . $user->last_name }}?"
                class="confirm-button btn btn-xs  mr-1 {{ $user->is_ban ? __('btn-outline-warning') : __('btn-outline-danger') }}">
                <i class="fa {{ $user->is_ban ? __('fa-play') : __('fa-pause') }}"></i>
            </button>
        </form>
    @endif

    @if ($user->deleted_at)
        <form action="{{ route('restore.user', $user->id) }}" method="POST" class="m-0 p-0">
            @csrf
            @method('PUT')
            <button title="Un-Delete User"
                data-message="to restore this user {{ $user->first_name . ' ' . $user->last_name }}?"
                data-action="restore" class="confirm-button btn btn-xs btn-outline-secondary mr-1">
                <i class="fa fa-undo"></i>
            </button>
        </form>
    @endif
</div>
