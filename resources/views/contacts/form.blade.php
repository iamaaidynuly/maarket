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
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_ru" class="control-label">{{ 'Заголовок RU' }}</label>
            <input class="form-control" name="title[ru]" type="text" id="title_ru"
                   value="{{ isset($contact->getTitle->ru) ? $contact->getTitle->ru : old('title.ru')}}">
            {!! $errors->first('title[ru]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            <label for="description_ru" class="control-label">{{ 'Описание RU' }}</label>
            <input class="form-control" name="description[ru]" type="text" id="description_ru"
                   value="{{ isset($contact->getDescription->ru) ? $contact->getDescription->ru : old('description.ru')}}">
            {!! $errors->first('description[ru]"', '<p class="help-block">:message</p>') !!}
        </div>
         <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
            <label for="address_ru" class="control-label">{{ 'Адрес RU' }}</label>
            <input class="form-control" name="main_address[ru]" type="text" id="address_ru" value="{{ isset($contact->getAddress->ru) ? $contact->getAddress->ru : old('address.ru')}}" >
            {!! $errors->first('address[ru]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_en" class="control-label">{{ 'Заголовок EN' }}</label>
            <input class="form-control" name="title[en]" type="text" id="title_en"
                   value="{{ isset($contact->getTitle->en) ? $contact->getTitle->en : old('title.en')}}">
            {!! $errors->first('title[en]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            <label for="description_en" class="control-label">{{ 'Описание EN' }}</label>
            <input class="form-control" name="description[en]" type="text" id="description_en"
                   value="{{ isset($contact->getDescription->en) ? $contact->getDescription->en : old('description.en')}}">
            {!! $errors->first('description[en]', '<p class="help-block">:message</p>') !!}
        </div>
         <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
            <label for="address_en" class="control-label">{{ 'Адрес EN' }}</label>
            <input class="form-control" name="main_address[en]" type="text" id="address_en" value="{{ isset($contact->getAddress->en) ? $contact->getAddress->en : old('title.en')}}" >
            {!! $errors->first('address[en]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">

        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_kz" class="control-label">{{ 'Заголовок KZ' }}</label>
            <input class="form-control" name="title[kz]" type="text" id="title_kz"
                   value="{{ isset($contact->getTitle->kz) ? $contact->getTitle->kz : old('title.kz')}}">
            {!! $errors->first('title[kz]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            <label for="description_kz" class="control-label">{{ 'Описание KZ' }}</label>
            <input class="form-control" name="description[kz]" type="text" id="description_kz"
                   value="{{ isset($contact->getDescription->kz) ? $contact->getDescription->kz : old('description.kz')}}">
            {!! $errors->first('description[kz]', '<p class="help-block">:message</p>') !!}
        </div>
         <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
            <label for="address_kz" class="control-label">{{ 'Адрес KZ' }}</label>
            <input class="form-control" name="main_address[kz]" type="text" id="address_kz" value="{{ isset($contact->getAddress->kz) ? $contact->getAddress->kz : old('title.kz')}}" >
            {!! $errors->first('address[kz]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>


<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'Почта' }}</label>
    <input class="form-control" name="email" type="text" id="email"
           value="{{ isset($contact->email) ? $contact->email : old('email.ru')}}">
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('whats_app') ? 'has-error' : ''}}">
    <label for="whats_app" class="control-label">{{ 'Whats_app' }}</label>
    <input class="form-control" name="whats_app" type="text" id="whats_app"
           value="{{ isset($contact->whats_app) ? $contact->whats_app : old('whats_app.ru')}}">
    {!! $errors->first('whats_app', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('telegram') ? 'has-error' : ''}}">
    <label for="telegram" class="control-label">{{ 'Telegram' }}</label>
    <input class="form-control" name="telegram" type="text" id="telegram"
           value="{{ isset($contact->telegram) ? $contact->telegram : old('telegram.ru')}}">
    {!! $errors->first('telegram', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('instagram') ? 'has-error' : ''}}">
    <label for="instagram" class="control-label">{{ 'Instagram' }}</label>
    <input class="form-control" name="instagram" type="text" id="instagram"
           value="{{ isset($contact->instagram) ? $contact->instagram : old('instagram.ru')}}">
    {!! $errors->first('instagram', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('vk') ? 'has-error' : ''}}">
    <label for="vk" class="control-label">{{ 'VK' }}</label>
    <input class="form-control" name="vk" type="text" id="vk"
           value="{{ isset($contact->vk) ? $contact->vk : old('vk.ru')}}">
    {!! $errors->first('vk', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('facebook') ? 'has-error' : ''}}">
    <label for="facebook" class="control-label">{{ 'Facebook' }}</label>
    <input class="form-control" name="facebook" type="text" id="facebook"
           value="{{ isset($contact->facebook) ? $contact->facebook : old('facebook.ru')}}">
    {!! $errors->first('facebook', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('map') ? 'has-error' : ''}}">
    <label for="map" class="control-label">{{ 'Карта ' }}</label>
    <input class="form-control" name="map" type="text" id="map"
           value="{{ isset($contact->map) ? $contact->map : null}}">
    {!! $errors->first('map', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('retail_sale') ? 'has-error' : ''}}">
    <label for="retail_sale" class="control-label">{{ 'Розничные продажи' }}</label>
    <input class="form-control" name="retail_sale" type="text" id="retail_sale"
           value="{{ isset($contact->retail_sale) ? $contact->retail_sale : null}}">
    {!! $errors->first('retail_sale', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('wholesale') ? 'has-error' : ''}}">
    <label for="wholesale" class="control-label">{{ 'Оптовые продажи' }}</label>
    <input class="form-control" name="wholesale" type="text" id="wholesale"
           value="{{ isset($contact->wholesale) ? $contact->wholesale : null}}">
    {!! $errors->first('wholesale', '<p class="help-block">:message</p>') !!}
</div>


<div id="phones">
    <div class="form-group">
        <label for="" class="control-label">{{ 'Номер телефона' }}</label>
        <br>
        <span id="add_phone" class="btn btn-success">Добавить</span>
    </div>
    @if(isset($contact->phone_number))
        @foreach (unserialize($contact->phone_number) as $item)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="form-control" name="phone_number[]" type="text"
                               value="{{ isset($item) ? $item : old('phone_number.ru')}}">
                    </div>
                </div>
                <div class="col-md-6"><span class="btn btn-danger delete_phone">Удалить</span></div>
            </div>
        @endforeach
    @else
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" name="phone_number[]" type="text"
                           value="{{ isset($contact->phone_number) ? $contact->phone_number : old('phone_number.ru')}}">
                </div>
            </div>
            <div class="col-md-6"><span class="btn btn-danger delete_phone">Удалить</span></div>
        </div>
    @endif
</div>
<div id="address">
    <div class="form-group">
        <label for="" class="control-label">{{ 'Адрес' }}</label>
        <br>
        <span id="add_address" class="btn btn-success">Добавить</span>
    </div>
    @if(isset($contact->address))
        @foreach (unserialize($contact->address) as $item)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="form-control" name="address[]" type="text"
                               value="{{ isset($item) ? $item : old('address.ru')}}">
                    </div>
                </div>
                <div class="col-md-6"><span class="btn btn-danger delete_address">Удалить</span></div>
            </div>
        @endforeach
    @else
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" name="address[]" type="text"
                           value="{{ isset($contact->address) ? $contact->address : old('address.ru')}}">
                </div>
            </div>
            <div class="col-md-6"><span class="btn btn-danger delete_address">Удалить</span></div>
        </div>
    @endif


</div>


<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Сохранить' : 'Добавить' }}">
</div>
