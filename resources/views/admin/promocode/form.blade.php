<div class="row">
    <div class="form-group col-md-4 {{ $errors->has('user_id') ? 'has-error' : ''}}">
        <select name="user_id" id="user_id" class="form-control js-example-basic-single" required>
            <option value="">Выберите пользователя</option>
            @foreach($users as $key => $value)
                <option value="{{$value->id}}">{{$value->name}} {{$value->email}}</option>
            @endforeach
        </select>
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('sale') ? 'has-error' : ''}}">
        <input class="form-control" name="sale" type="text" id="sale" value="" placeholder="Скидка" required>
        {!! $errors->first('sale', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('exp_date') ? 'has-error' : ''}}">
        <input class="form-control" name="exp_date" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="exp_date" value="" placeholder="Дата окончания" required>
        {!! $errors->first('exp_date', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Создать' }}">
    </div>
</div>
