<div class="form-group {{ $errors->has('ru') ? 'has-error' : ''}}">
    <label for="ru" class="control-label">{{ 'Ru' }}</label>
    <textarea class="form-control" rows="5" name="ru" type="textarea" id="ru" >{{ isset($translate->ru) ? $translate->ru : ''}}</textarea>
    {!! $errors->first('ru', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('en') ? 'has-error' : ''}}">
    <label for="en" class="control-label">{{ 'En' }}</label>
    <textarea class="form-control" rows="5" name="en" type="textarea" id="en" >{{ isset($translate->en) ? $translate->en : ''}}</textarea>
    {!! $errors->first('en', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
