@if (isset($filters))
    @foreach ($filters as $item)
        <optgroup label="{{$item->getTitle->ru}}">
            @if($item->getItems)
                @foreach($item->getItems as $key => $value)
                    <option value="{{$value->id}}">{{$value->getTitle->ru}}</option>
                @endforeach
            @endif
        </optgroup>
    @endforeach
@endif
