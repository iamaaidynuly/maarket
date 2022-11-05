<div class="container-fluid">
    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
        <label for="name" class="control-label">{{ 'Имя' }}</label>
        <input class="form-control" name="name" type="text" id="name"
               value="{{ isset($feedback->name) ? $feedback->name : old('name')}}">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
        <label for="phone_number" class="control-label">{{ 'Логин' }}</label>
        <input class="form-control" name="phone_number" type="text" id="phone_number"
               value="{{ isset($feedback->phone_number) ? $feedback->phone_number : old('phone_number')}}">
        {!! $errors->first('phone_number', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
        <label for="type" class="control-label">{{ 'Тема' }}</label>
        <input class="form-control" name="type" type="text" id="type"
               value="{{ isset($feedback->type) ? $feedback->type : old('type')}}">
        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
        <label for="text" class="control-label">{{ 'Текст' }}</label>
        <input class="form-control" name="text" type="text" id="text"
               value="{{ isset($feedback->text) ? $feedback->text : old('text')}}">
        {!! $errors->first('text', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Сохранить' : 'Добавить' }}">
</div>
