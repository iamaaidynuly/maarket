@if($formMode != 'edit')
    <div class="form-group col-md-12 {{ $errors->has('image') ? 'has-error' : ''}}">
        <label for="type" class="control-label">{{ 'Выберите тип: ' }}</label>
        <select class="form-control" name="type" id="type">
            <option value="about">О нас</option>
            <option value="loyalty">Установка</option>
            <option value="cooperation">Сотрудничество</option>
            <option value="delivery">Доставка и самовывоз</option>
            <option value="payment">Оптовый отдел</option>
            {{--        <option value="return">Возврат</option>--}}
            <option value="faq">Частые вопросы</option>
            <option value="contacts">Страница Контакты</option>
            <option value="offer">Оферта</option>
            <option value="confidentiality">Конфиденциальность</option>
            <option value="personal_data">Политика обработки персональных данных</option>
            <option value="insta">Инстаграм</option>
            <option value="banner">Баннеры</option>
            <option value="promocode">Промокод</option>
        </select>
    </div>
@endif

<div class="form-group col-md-12 {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="image" class="control-label">{{ 'Логотип (1400x630px)' }}</label>
    <input class="form-control" name="image" type="file" id="image"
           value="{{ isset($aboutusblock->image) ? $aboutusblock->image : ''}}">
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}

    @if(isset($aboutusblock->image))
        <br>
        <img src="{{ \Config::get('constants.alias.cdn_url').$aboutusblock->image }}" alt="" style="max-width: 400px;">
        <br>
    @endif
</div>

<div class="col-md-12">
    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
        <li class="nav-item active">
            <a class="nav-link active" id="custom-tabs-one-ru-tab" data-toggle="pill" href="#custom-tabs-one-ru"
               role="tab" aria-controls="custom-tabs-one-ru" aria-selected="true">Русский</a>
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
</div>

<div class="tab-content col-md-12" id="custom-tabs-one-tabContent">
    <div class="tab-pane fade active in" id="custom-tabs-one-ru" role="tabpanel"
         aria-labelledby="custom-tabs-one-ru-tab">
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_ru" class="control-label">{{ 'Наименование RU' }}</label>
            <input class="form-control" name="title[ru]" type="text" id="title_ru"
                   value="{{ isset($aboutusblock->getTitle->ru) ? $aboutusblock->getTitle->ru : old('title.ru')}}">
            {!! $errors->first('title[ru]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_ru" class="control-label">{{ 'Описание RU' }}</label>
            <textarea name="content[ru]" id="content_ru" cols="30"
                      rows="10">{{ isset($aboutusblock->getDescription->ru) ? $aboutusblock->getDescription->ru : old('content.ru')}}</textarea>
            {!! $errors->first('content[ru]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_en" class="control-label">{{ 'Наименование EN' }}</label>
            <input class="form-control" name="title[en]" type="text" id="title_en"
                   value="{{ isset($aboutusblock->getTitle->en) ? $aboutusblock->getTitle->en : old('title.en')}}">
            {!! $errors->first('title[en]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_en" class="control-label">{{ 'Описание EN' }}</label>
            <textarea name="content[en]" id="content_en" cols="30"
                      rows="10">{{ isset($aboutusblock->getDescription->en) ? $aboutusblock->getDescription->en : old('content.en')}}</textarea>
            {!! $errors->first('content[en]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_kz" class="control-label">{{ 'Наименование KZ' }}</label>
            <input class="form-control" name="title[kz]" type="text" id="title_kz"
                   value="{{ isset($aboutusblock->getTitle->kz) ? $aboutusblock->getTitle->kz : old('title.kz')}}">
            {!! $errors->first('title[kz]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_kz" class="control-label">{{ 'Описание KZ' }}</label>
            <textarea name="content[kz]" id="content_kz" cols="30"
                      rows="10">{{ isset($aboutusblock->getDescription->kz) ? $aboutusblock->getDescription->kz : old('content.kz')}}</textarea>
            {!! $errors->first('content[kz]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group col-md-12{{ $errors->has('url') ? 'has-error' : ''}}">
    <label for="url" class="control-label">{{ 'Ссылка' }}</label>
    <input class="form-control" name="url" type="text" id="url"
           value="{{ isset($aboutusblock->url) ? $aboutusblock->url : old('url')}}">
    {!! $errors->first('url', '<p class="help-block">:message</p>') !!}

    <input type="hidden" name="slug" value="{{isset($aboutusblock) ? $aboutusblock->slug : null}}">
</div>

<div class="form-group col-md-12 {{ $errors->has('images') ? 'has-error' : '' }}">
    <label for="additional_images" class="control-label">{{ 'Доп. Изображении' }}</label>
    <input type="file" name="additional_images[]" id="additional_images" class="form-control" multiple>
    {!! $errors->first('images', '<p class="help-block">:message</p>') !!}
    @if (isset($images))
        <br><br>
        <div class="row">
            @foreach ($images as $item)
                <div class="col-md-3">
                    <div class="img-wrapper" style="position:reklative">
                        <img src="{{ \Config::get('constants.alias.cdn_url') }}/{{ $item->image }}" alt=""
                             style="max-width:100%">
                        <span data-id="{{ $item->id }}" class="btn btn-danger delete-img-product"
                              style="position:absolute; top:0; right:0">Удалить</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>


<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>
