<div class="form-group col-md-12 {{ $errors->has('link') ? 'has-error' : ''}}">
    <label for="link" class="control-label">{{ 'Ссылка' }}</label>
    <input class="form-control" name="link" type="text" id="link" value="{{ isset($instum->link) ? $instum->link : old('link')}}" required>
    {!! $errors->first('link', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12 {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="image" class="control-label">{{ 'Картинка' }}</label>
    <input class="form-control" name="image" type="file" id="image" value="{{ isset($instum->image) ? $instum->image : ''}}" >
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
    
    @if(isset($instum->image))
        <br>
       <img src="{{ \Config::get('constants.alias.cdn_url').$instum->image }}" alt="" style="max-width: 400px;"> 
       <br>
    @endif
    
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Сохранить' : 'Добавить' }}">
</div>
