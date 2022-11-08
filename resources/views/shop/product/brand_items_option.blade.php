@if (isset($brand_items))
    @foreach ($brand_items as $item)
        <option value="{{$item->id}}">{{$item->getTitle->ru}}</option>
    @endforeach
@endif
