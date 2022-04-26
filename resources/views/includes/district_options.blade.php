<option value=""></option>
@foreach ($districts as $item)
<option data-district="{{ $item->name }}" value="{{ $item->id }}" {{ $request->district_id && $request->district_id == $item->id ? 'selected=selected' : '' }}>{{ $item->name }}</option>
@endforeach
