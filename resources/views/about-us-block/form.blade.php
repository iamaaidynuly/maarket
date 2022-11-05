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
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_ru" class="control-label">{{ 'Описание RU' }}</label>
            <textarea name="content[ru]" id="content_ru" cols="30"
                      rows="10">{{ isset($aboutusblock->getContent->ru) ? $aboutusblock->getContent->ru : old('content.ru')}}</textarea>
            {!! $errors->first('content[ru]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_en" class="control-label">{{ 'Описание EN' }}</label>
            <textarea name="content[en]" id="content_en" cols="30"
                      rows="10">{{ isset($aboutusblock->getContent->en) ? $aboutusblock->getContent->en : old('content.en')}}</textarea>
            {!! $errors->first('content[en]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_kz" class="control-label">{{ 'Описание KZ' }}</label>
            <textarea name="content[kz]" id="content_kz" cols="30"
                      rows="10">{{ isset($aboutusblock->getContent->kz) ? $aboutusblock->getContent->kz : old('content.kz')}}</textarea>
            {!! $errors->first('content[kz]"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
    <label for="url" class="control-label">{{ 'Ссылка' }}</label>
    <input class="form-control" name="url" type="text" id="url"
           value="{{ isset($aboutusblock->url) ? $aboutusblock->url : old('url')}}">
    {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>
