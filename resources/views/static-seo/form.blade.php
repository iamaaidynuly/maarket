<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
    <li class="nav-item active">
        <a class="nav-link active" id="custom-tabs-one-ru-tab" data-toggle="pill" href="#custom-tabs-one-ru" role="tab" aria-controls="custom-tabs-one-ru" aria-selected="true">Русский</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-en-tab" data-toggle="pill" href="#custom-tabs-one-en" role="tab" aria-controls="custom-tabs-one-en" aria-selected="false">Английский</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-kz-tab" data-toggle="pill" href="#custom-tabs-one-kz" role="tab" aria-controls="custom-tabs-one-kz" aria-selected="false">Казахский</a>
    </li>
</ul>

<div class="tab-content" id="custom-tabs-one-tabContent">
    <div class="tab-pane fade active in" id="custom-tabs-one-ru" role="tabpanel" aria-labelledby="custom-tabs-one-ru-tab">
        <div class="form-group {{ $errors->has('meta_title.ru') ? 'has-error' : ''}}">
            <label for="meta_title_ru" class="control-label">{{ 'Мета заголовок RU' }}</label>
            <input class="form-control" name="meta_title[ru]" type="text" id="meta_title_ru" value="{{ isset($staticseo->metaTitle->ru) ? $staticseo->metaTitle->ru : old('meta_title.ru')}}">
            {!! $errors->first('meta_title.ru', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content.ru') ? 'has-error' : ''}}">
            <label for="content" class="control-label">{{ 'Мета описание RU' }}</label>
            <input class="form-control" name="meta_description[ru]" type="text" id="content" value="{{ isset($staticseo->metaDesc->ru) ? $staticseo->metaDesc->ru : old('meta_description.ru')}}" >
            {!! $errors->first('content.ru', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="form-group {{ $errors->has('meta_title.en') ? 'has-error' : ''}}">
            <label for="meta_title_en" class="control-label">{{ 'Мета заголовок EN' }}</label>
            <input class="form-control" name="meta_title[en]" type="text" id="meta_title_en" value="{{ isset($staticseo->metaTitle->en) ? $staticseo->metaTitle->en : old('meta_title.en')}}" >
            {!! $errors->first('meta_title.en', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('meta_description.en') ? 'has-error' : ''}}">
            <label for="meta_description_en" class="control-label">{{ 'Мета описание EN' }}</label>
            <input class="form-control" name="meta_description[en]" type="text" id="meta_description_en" value="{{ isset($staticseo->metaDesc->en) ? $staticseo->metaDesc->en : old('meta_description.en')}}" >
            {!! $errors->first('meta_description.en', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
        <div class="form-group {{ $errors->has('meta_title.kz') ? 'has-error' : ''}}">
            <label for="meta_title_kz" class="control-label">{{ 'Мета заголовок KZ' }}</label>
            <input class="form-control" name="meta_title[kz]" type="text" id="meta_title_kz" value="{{ isset($staticseo->metaTitle->kz) ? $staticseo->metaTitle->kz : old('meta_title.kz')}}" >
            {!! $errors->first('meta_title.kz', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('meta_description.kz') ? 'has-error' : ''}}">
            <label for="meta_description_kz" class="control-label">{{ 'Мета описание KZ' }}</label>
            <input class="form-control" name="meta_description[kz]" type="text" id="meta_description_kz" value="{{ isset($staticseo->metaDesc->kz) ? $staticseo->metaDesc->kz : old('meta_description.kz')}}" >
            {!! $errors->first('meta_description.kz', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<input type="text" hidden name="title" value="{{request('title')}}">
<input type="text" hidden name="page" value="{{request('page')}}">
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>
