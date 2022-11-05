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

<div class="tab-content col-md-12" id="custom-tabs-one-tabContent">
    <div class="tab-pane fade active in" id="custom-tabs-one-ru" role="tabpanel"
         aria-labelledby="custom-tabs-one-ru-tab">
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_ru" class="control-label">{{ 'Наименование RU' }}</label>
            <input class="form-control" name="title[ru]" type="text" id="title_ru"
                   value="{{ isset($slider->getTitle->ru) ? $slider->getTitle->ru : old('title.ru')}}">
            {!! $errors->first('title[ru]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_ru" class="control-label">{{ 'Описание RU' }}</label>
            <textarea class="form-control" name="content[ru]" type="text" id="content_ru">
                {{ isset($slider->getContent->ru) ? $slider->getContent->ru : old('content.ru')}}
            </textarea>
            {!! $errors->first('content[ru]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_en" class="control-label">{{ 'Наименование EN' }}</label>
            <input class="form-control" name="title[en]" type="text" id="title_en"
                   value="{{ isset($slider->getTitle->en) ? $slider->getTitle->en : old('title.en')}}">
            {!! $errors->first('title[en]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_ru" class="control-label">{{ 'Описание EN' }}</label>
            <textarea class="form-control" name="content[en]" type="text" id="content_en">
                {{ isset($slider->getContent->en) ? $slider->getContent->en : old('content.en')}}
            </textarea>
            {!! $errors->first('content[ru]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_kz" class="control-label">{{ 'Наименование KZ' }}</label>
            <input class="form-control" name="title[kz]" type="text" id="title_kz"
                   value="{{ isset($slider->getTitle->kz) ? $slider->getTitle->kz : old('title.kz')}}">
            {!! $errors->first('title[kz]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_kz" class="control-label">{{ 'Описание KZ' }}</label>
            <textarea class="form-control" name="content[kz]" type="text" id="content_kz">
                {{ isset($slider->getContent->kz) ? $slider->getContent->kz : old('content.kz')}}
            </textarea>
            {!! $errors->first('content[kz]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
        <label for="image" class="control-label">{{ 'Изображение слайда' }}</label>
        <input class="form-control" name="image" type="file" id="image" value="{{ isset($slider->image) ? $slider->image : ''}}" >
        {!! $errors->first('image', '<p class="help-block">:message</p>') !!}

        @if(isset($slider->image))
            <br>
           <img src="{{ \Config::get('constants.alias.cdn_url').$slider->image }}" alt="" style="max-width: 400px;">
           <br>
        @endif

    </div>
    <div class="form-group {{ $errors->has('image_mobile') ? 'has-error' : ''}}">
        <label for="image_mobile" class="control-label">{{ 'Изображение(mobile)' }}</label>
        <input class="form-control" name="image_mobile" type="file" id="image_mobile" value="{{ isset($slider->image_mobile) ? $slider->image_mobile : ''}}" >
        {!! $errors->first('image_mobile', '<p class="help-block">:message</p>') !!}

        @if(isset($slider->image_mobile))
            <br>
           <img src="{{ \Config::get('constants.alias.cdn_url').$slider->image_mobile }}" alt="" style="max-width: 400px;">
           <br>
        @endif

    </div>
    <div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
        <label for="url" class="control-label">{{ 'Ссылка' }}</label>
        <input class="form-control" name="url" type="text" id="url" value="{{ isset($slider->url) ? $slider->url : old('url')}}" >
        {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Добавить' }}">
    </div>
</div>

