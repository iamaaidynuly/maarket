<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
    <li class="nav-item active">
        <a class="nav-link active" id="custom-tabs-one-ru-tab" data-toggle="pill" href="#custom-tabs-one-ru" role="tab"
           aria-controls="custom-tabs-one-ru" aria-selected="true">Русский</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-en-tab" data-toggle="pill" href="#custom-tabs-one-en" role="tab"
           aria-controls="custom-tabs-one-en" aria-selected="false">Английский</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-kz-tab" data-toggle="pill" href="#custom-tabs-one-kz" role="tab"
           aria-controls="custom-tabs-one-kz" aria-selected="false">Казахский</a>
    </li>
</ul>

<div class="tab-content" id="custom-tabs-one-tabContent">
    <div class="tab-pane fade active in" id="custom-tabs-one-ru" role="tabpanel"
         aria-labelledby="custom-tabs-one-ru-tab">
        <div class="form-group col-md-12 {{ $errors->has('title.ru') ? 'has-error' : '' }}">
            <label for="title_ru" class="control-label">{{ 'Название Ru' }}</label>
            <input class="form-control" name="title[ru]" type="text" id="title_ru"
                   value="{{ isset($shop->title) ? $shop->getTitle->ru : old('title.ru') }}">
            {!! $errors->first('title.ru', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group col-md-12 {{ $errors->has('description.ru') ? 'has-error' : '' }}">
            <label for="description_ru" class="control-label">{{ 'Описание Ru' }}</label>
            <textarea class="form-control" name="description[ru]" id="description_ru" rows="10">{{ isset($shop->description) ? $shop->getDesc->ru : old('description.ru') }}</textarea>
            {!! $errors->first('description.ru', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group col-md-12 {{ $errors->has('address.ru') ? 'has-error' : '' }}">
            <label for="address_ru" class="control-label">{{ 'Адрес Ru' }}</label>
            <input class="form-control" name="address[ru]" type="text" id="address_ru"
                   value="{{ isset($shop->address) ? $shop->getAddress->ru : old('address.ru') }}">
            {!! $errors->first('address.ru', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group col-md-12 {{ $errors->has('min_price.ru') ? 'has-error' : '' }}">
            <label for="min_price_ru" class="control-label">{{ 'Мин.Сумма Ru' }}</label>
            <input class="form-control" name="min_price[ru]" type="text" id="min_price_ru"
                   value="{{ isset($shop->min_price) ? $shop->getAddress->ru : old('min_price.ru') }}">
            {!! $errors->first('min_price.ru', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group col-md-12 {{ $errors->has('delivery.ru') ? 'has-error' : '' }}">
            <label for="delivery_ru" class="control-label">{{ 'Доставка Ru' }}</label>
            <input class="form-control" name="delivery[ru]" type="text" id="delivery_ru"
                   value="{{ isset($shop->delivery) ? $shop->getAddress->ru : old('delivery.ru') }}">
            {!! $errors->first('delivery.ru', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="form-group col-md-12 {{ $errors->has('title.en') ? 'has-error' : '' }}">
            <label for="title_en" class="control-label">{{ 'Название En' }}</label>
            <input class="form-control" name="title[en]" type="text" id="title_en"
                   value="{{ isset($shop->title) ? $shop->getTitle->en : old('title.en') }}">
            {!! $errors->first('title.en', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group col-md-12 {{ $errors->has('description.en') ? 'has-error' : '' }}">
            <label for="description_en" class="control-label">{{ 'Описание En' }}</label>
            <textarea class="form-control" name="description[en]" id="description_en" rows="10">{{ isset($shop->description) ? $shop->getDesc->en : old('description.en') }}</textarea>
            {!! $errors->first('description.en', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group col-md-12 {{ $errors->has('address.en') ? 'has-error' : '' }}">
            <label for="address_en" class="control-label">{{ 'Адрес EN' }}</label>
            <input class="form-control" name="address[en]" type="text" id="address_en"
                   value="{{ isset($shop->address) ? $shop->getAddress->en : old('address.en') }}">
            {!! $errors->first('address.en', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group col-md-12 {{ $errors->has('min_price.en') ? 'has-error' : '' }}">
            <label for="min_price_en" class="control-label">{{ 'Мин.Сумма EN' }}</label>
            <input class="form-control" name="min_price[en]" type="text" id="min_price_en"
                   value="{{ isset($shop->min_price) ? $shop->getAddress->en : old('min_price.en') }}">
            {!! $errors->first('min_price.en', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group col-md-12 {{ $errors->has('delivery.en') ? 'has-error' : '' }}">
            <label for="delivery_en" class="control-label">{{ 'Доставка EN' }}</label>
            <input class="form-control" name="delivery[en]" type="text" id="delivery_en"
                   value="{{ isset($shop->delivery) ? $shop->getAddress->en : old('delivery.en') }}">
            {!! $errors->first('delivery.en', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
        <div class="form-group col-md-12 {{ $errors->has('title.kz') ? 'has-error' : '' }}">
            <label for="title_kz" class="control-label">{{ 'Название Kz' }}</label>
            <input class="form-control" name="title[kz]" type="text" id="title_kz"
                   value="{{ isset($shop->title) ? $shop->getTitle->kz : old('title.kz') }}">
            {!! $errors->first('title.kz', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group col-md-12 {{ $errors->has('description.kz') ? 'has-error' : '' }}">
            <label for="description_kz" class="control-label">{{ 'Описание Kz' }}</label>
            <textarea class="form-control" name="description[kz]" id="description_kz" rows="10">
                {{ isset($shop->description) ? $shop->getDesc->kz : old('description.kz') }}
            </textarea>
            {!! $errors->first('description.kz', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group col-md-12 {{ $errors->has('address.kz') ? 'has-error' : '' }}">
            <label for="address_kz" class="control-label">{{ 'Адрес KZ' }}</label>
            <input class="form-control" name="address[kz]" type="text" id="address_kz"
                   value="{{ isset($shop->address) ? $shop->getAddress->kz : old('address.kz') }}">
            {!! $errors->first('address.kz', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group col-md-12 {{ $errors->has('min_price.kz') ? 'has-error' : '' }}">
            <label for="min_price_kz" class="control-label">{{ 'Мин.Сумма KZ' }}</label>
            <input class="form-control" name="min_price[kz]" type="text" id="min_price_kz"
                   value="{{ isset($shop->min_price) ? $shop->getAddress->kz : old('min_price.kz') }}">
            {!! $errors->first('min_price.kz', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group col-md-12 {{ $errors->has('delivery.kz') ? 'has-error' : '' }}">
            <label for="delivery_kz" class="control-label">{{ 'Доставка KZ' }}</label>
            <input class="form-control" name="delivery[kz]" type="text" id="delivery_kz"
                   value="{{ isset($shop->delivery) ? $shop->getAddress->kz : old('delivery.kz') }}">
            {!! $errors->first('delivery.kz', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group col-md-6 {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="control-label">{{ 'Логин:' }}</label>
    <input class="form-control" name="email" type="email" id="email"
           value="{{ isset($shop->email) ? $shop->email : old('email') }}">
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6 {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="control-label">{{ 'Пароль:' }}</label>
    <input class="form-control" name="password" type="password" id="password"
           value="{{ isset($shop->password) ? $shop->password : old('password') }}">
    {!! $errors->first('sale', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6" {{ $errors->has('city_id') ? 'has-error' : '' }}>
    <label for="city_id" class="control-label">{{ 'Город:' }}</label>
    <select class="form-control" id="city_id" name="city_id">
        @foreach($cities as $city)
            <option value="{{$city->id}}" @if(isset($shop)) @if($city->id == $shop->city_id) selected @endif @endif>{{ $city->getTitle->ru }}</option>
        @endforeach
    </select>
    {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6" {{ $errors->has('icon') ? 'has-error' : '' }}>
    <label for="icon" class="control-label">{{ 'Иконка:' }}</label>
    <input type="file" name="icon" class="form-control" id="icon">
    {!! $errors->first('icon', '<p class="help-block">:message</p>') !!}
</div>

<div class="col-md-12">
    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
    </div>
</div>
