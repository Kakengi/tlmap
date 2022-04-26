<option value="">Select Publication...</option>
@foreach($publications as $item)
<option value="{{ $item->publication_id }}" {{ $request->has('selected_publication_id') && $request->selected_publication_id  == $item->publication_id ? 'selected=selected' : '' }}>


    {{ $item->title }}
</option>
@endforeach
