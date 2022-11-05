<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Имя' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($review->name) ? $review->name : ''}}"
           required>
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('review') ? 'has-error' : ''}}">
    <label for="review" class="control-label">{{ 'Отзыв' }}</label>
    <textarea class="form-control" name="review" id="review" rows="10"
              required>{{ isset($review->review) ? $review->review : old('review')}}</textarea>
    {!! $errors->first('review', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('rating') ? 'has-error' : ''}}">
    <label for="rating" class="control-label">{{ 'Рейтинг' }}</label>
    <input class="form-control" name="rating" id="rating"
           value="{{ isset($review->rating) ? $review->rating : ''}}" required>
    {!! $errors->first('rating', '<p class="help-block">:message</p>') !!}
</div>
@if($products)
    <div class="form-group {{ $errors->has('Продукт') ? 'has-error' : ''}} ">
        <label for="product_id" class="control-label">{{ 'Продукт' }}</label>
        <select name="product_id" id="product_id" class="form-control js-example-basic-single">
            @foreach($products as $item)
                <option value="{{$item->id}}"
                        @if(isset($review) && $item->id == $review->product_id) selected @endif>{{$item->title}}</option>
            @endforeach
        </select>
        {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
    </div>
@endif


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>
