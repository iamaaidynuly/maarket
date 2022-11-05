<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Почта' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($mail->title) ? $mail->title : ''}}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Сохранить' : 'Добавить' }}">
</div>