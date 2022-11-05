
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
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_ru" class="control-label">{{ 'Заголовок RU' }}</label>
            <input class="form-control" name="title[ru]" type="text" id="title_ru" value="{{ isset($article->getTitle->ru) ? $article->getTitle->ru : old('title.ru')}}" >
            {!! $errors->first('title[ru]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            <label for="description_ru" class="control-label">{{ 'Описание RU' }}</label>
            <input class="form-control" name="description[ru]" type="text" id="description_ru" value="{{ isset($article->getDescription->ru) ? $article->getDescription->ru : old('address.ru')}}" >
            {!! $errors->first('description[ru]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_kz" class="control-label">{{ 'Заголовок KZ' }}</label>
            <input class="form-control" name="title[kz]" type="text" id="title_kz" value="{{ isset($article->getTitle->kz) ? $article->getTitle->kz : old('title.kz')}}" >
            {!! $errors->first('title[kz]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            <label for="description_kz" class="control-label">{{ 'Описание KZ' }}</label>
            <input class="form-control" name="description[kz]" type="text" id="description_kz" value="{{ isset($article->getDescription->kz) ? $article->getDescription->kz : old('title.kz')}}" >
            {!! $errors->first('description[kz]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            <label for="title_en" class="control-label">{{ 'Заголовок EN' }}</label>
            <input class="form-control" name="title[en]" type="text" id="title_en" value="{{ isset($article->getTitle->en) ? $article->getTitle->en : old('title.en')}}" >
            {!! $errors->first('title[en]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            <label for="description_en" class="control-label">{{ 'Описание EN' }}</label>
            <input class="form-control" name="description[en]" type="text" id="description_en" value="{{ isset($article->getDescription->en) ? $article->getDescription->en : old('title.en')}}" >
            {!! $errors->first('description[en]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="image" class="control-label">{{ 'Изображение слайда (1400x630px)' }}</label>
    <input class="form-control" name="image" type="file" id="image" value="{{ isset($article->image) ? $article->image : ''}}" >
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
    
    @if(isset($article->image))
        <br>
       <img src="{{ \Config::get('constants.alias.cdn_url').$article->image }}" alt="" style="max-width: 400px;"> 
       <br>
    @endif
    
</div>



<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Добавить' }}">
</div>
