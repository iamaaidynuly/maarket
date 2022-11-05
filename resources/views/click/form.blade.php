<div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
    <label for="phone_number" class="control-label">{{ 'Номер телефона' }}</label>
    <input class="form-control" name="phone_number" type="text" id="phone_number" value="{{ isset($click->phone_number) ? $click->phone_number : ''}}" >
    {!! $errors->first('phone_number', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="product_id" class="control-label">{{ 'Наименование продукта' }}</label>
    <input class="form-control" name="product_id" type="text" id="product_id" value="{{ isset($click->product_id) ? $click->product_id : ''}}" >
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="artikul" class="control-label">{{ 'Артикул' }}</label>
    <input class="form-control" name="artikul" type="text" id="artikul" value="{{ isset($click->artikul) ? $click->artikul : ''}}" >
    {!! $errors->first('artikul', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>
