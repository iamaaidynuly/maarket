@if (isset($sizes))
@foreach ($sizes as $item)
        <option value="{{$item->id}}">{{$item->getTitle->ru}}</option>
@endforeach
@endif