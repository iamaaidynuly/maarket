<div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Имя' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : ''}}">
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('l_name') ? 'has-error' : ''}}">
    <label for="l_name" class="control-label">{{ 'Фамилия' }}</label>
    <input class="form-control" name="l_name" type="text" id="l_name"
           value="{{ isset($user->lname) ? $user->lname : ''}}">
    {!! $errors->first('l_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-12 {{ $errors->has('phone') ? 'has-error' : ''}}">
    <label for="phone_number" class="control-label">{{ 'Телефон' }}</label>
    <input class="form-control" name="phone_number" type="text" id="phone_number"
           value="{{ isset($user->phone_number) ? $user->phone_number : ''}}">
    {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-12 {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'E-mail' }}</label>
    <input class="form-control" name="email" type="text" id="email"
           value="{{ isset($user->email) ? $user->email : ''}}">
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12" {{$errors->has('discount') ? 'has-error' : ''}}>
    <label for="discount">Скидка в процентах:</label>
    <input class="form-control" name="discount" type="text" id="discount"
           value="{{ isset($user->discount) ? $user->discount : ''}}">
    {!! $errors->first('discount', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-12 {{ $errors->has('type') ? 'has-error' : ''}}">
    <label for="type" class="control-label">{{ 'Тип пользователя' }}</label>
    <select class="form-control" name="type" id="type">
        <option value="individual" @if($user->type == 'individual') selected @endif>Физ.лицо</option>
        <option value="entity" @if($user->type == 'entity') selected @endif>Юр.лицо</option>
    </select>
</div>

@if($user)
    @if($user->type == 'entity')
        <div class="form-group col-md-12">
            <label for="price_type_id">Тип цены для пользователя:</label>
            <select class="form-control" name="price_type_id" id="price_type_id">
                <option value="0" @if($user->price_type_id == 0) selected @endif>Обычный</option>
                @foreach($priceTypes as $type)
                    <option value="{{$type->id}}"
                            @if($user->price_type_id == $type->id) selected @endif>{{$type->name}}</option>
                @endforeach
            </select>
        </div>
    @endif
@endif

<div class="form-group col-md-12">
    <label for="type" class="control-label">{{ 'Прошел верификацию' }}</label>
    <input type="checkbox" name="email_verified"
           value="1" {{$user->email_verified_at == null ? '' : 'checked="checked"'}}>
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>
