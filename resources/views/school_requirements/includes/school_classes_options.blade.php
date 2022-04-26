<option value="">Select Class(es) ...</option>
@foreach ($classess as $item)
<option value="{{ $item->id }}" {{ in_array($item->id, $school_class_ids) ? 'selected=selected' : '' }}>
    {{ $item->name }}
</option>
@endforeach
