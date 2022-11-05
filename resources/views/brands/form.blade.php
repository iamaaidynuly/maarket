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
                   value="{{ isset($brand->getTitle->ru) ? $brand->getTitle->ru : old('title.ru')}}">
            {!! $errors->first('title[ru]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_ru" class="control-label">{{ 'Описание RU' }}</label>
            <input class="form-control" name="content[ru]" type="text" id="content_ru"
                   value="{{ isset($brand->getContent->ru) ? $brand->getContent->ru : old('content.ru')}}">
            {!! $errors->first('content[ru]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_en" class="control-label">{{ 'Наименование EN' }}</label>
            <input class="form-control" name="title[en]" type="text" id="title_en"
                   value="{{ isset($brand->getTitle->en) ? $brand->getTitle->en : old('title.en')}}">
            {!! $errors->first('title[en]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_ru" class="control-label">{{ 'Описание EN' }}</label>
            <input class="form-control" name="content[en]" type="text" id="content_ru"
                   value="{{ isset($brand->getContent->en) ? $brand->getContent->en : old('content.en')}}">
            {!! $errors->first('content[ru]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_kz" class="control-label">{{ 'Наименование KZ' }}</label>
            <input class="form-control" name="title[kz]" type="text" id="title_kz"
                   value="{{ isset($brand->getTitle->kz) ? $brand->getTitle->kz : old('title.kz')}}">
            {!! $errors->first('title[kz]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_kz" class="control-label">{{ 'Описание KZ' }}</label>
            <input class="form-control" name="content[kz]" type="text" id="content_kz"
                   value="{{ isset($brand->getContent->kz) ? $brand->getContent->kz : old('content.kz')}}">
            {!! $errors->first('content[kz]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

{{--<div class="form-group col-md-12 {{ $errors->has('table_size') ? 'has-error' : ''}}">--}}
{{--    <label for="table_size" class="control-label">{{ 'Таблица размеров' }}</label>--}}
{{--    <input class="form-control" name="table_size" type="file" id="table_size"--}}
{{--           value="{{ isset($brand->table_size) ? $brand->table_size : ''}}">--}}
{{--    {!! $errors->first('table_size', '<p class="help-block">:message</p>') !!}--}}

{{--    @if(isset($brand->table_size))--}}
{{--        <br>--}}
{{--        <img src="{{ \Config::get('constants.alias.cdn_url').$brand->table_size }}" alt="" style="max-width: 400px;">--}}
{{--        <br>--}}
{{--    @endif--}}

{{--</div>--}}

<div class="form-group col-md-12 {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="image" class="control-label">{{ 'Логотип (1400x630px)' }}</label>
    <input class="form-control" name="image" type="file" id="image"
           value="{{ isset($brand->image) ? $brand->image : ''}}">
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}

    @if(isset($brand->image))
        <br>
        <img src="{{ \Config::get('constants.alias.cdn_url').$brand->image }}" alt="" style="max-width: 400px;">
        <br>
    @endif

</div>


<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Сохранить' : 'Добавить' }}">
</div>
