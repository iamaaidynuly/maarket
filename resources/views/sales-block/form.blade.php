<div class="card-header p-0 pt-1 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
    <li class="nav-item active">
        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Русский</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Английский</a>
    </li>
    </ul>
</div>
<div class="card-body">
    <div class="tab-content" id="custom-tabs-two-tabContent">
    <div class="tab-pane fade active in" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
        <div class="col-md-12">
            <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                <label for="title_ru" class="control-label">{{ 'Заголовок RU' }}</label>
                <input class="form-control" name="title[ru]" type="text" id="title_ru" value="{{ isset($salesblock->getTitle->ru) ? $salesblock->getTitle->ru : old('title.ru')}}" >
                {!! $errors->first('title[ru]', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
                <label for="content_ru" class="control-label">{{ 'Описание RU' }}</label>
                <input class="form-control" name="content[ru]" type="text" id="content_ru" value="{{ isset($salesblock->getContent->ru) ? $salesblock->getContent->ru : old('content.ru')}}" >
                {!! $errors->first('content[ru]"', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
                <label for="url_ru" class="control-label">{{ 'Ссылка RU' }}</label>
                <input class="form-control" name="url[ru]" type="text" id="url_ru" value="{{ isset($salesblock->getUrl->ru) ? $salesblock->getUrl->ru : old('url.ru')}}" >
                {!! $errors->first('url[ru]', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
        <div class="col-md-12">
            <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                <label for="title_en" class="control-label">{{ 'Заголовок EN' }}</label>
                <input class="form-control" name="title[en]" type="text" id="title_en" value="{{ isset($salesblock->getTitle->en) ? $salesblock->getTitle->en : old('title.en')}}" >
                {!! $errors->first('title[en]', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
                <label for="content_ru" class="control-label">{{ 'Описание EN' }}</label>
                <input class="form-control" name="content[en]" type="text" id="content_ru" value="{{ isset($salesblock->getContent->en) ? $salesblock->getContent->en : old('content.en')}}" >
                {!! $errors->first('content[ru]"', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
                <label for="url_en" class="control-label">{{ 'Ссылка EN' }}</label>
                <input class="form-control" name="url[en]" type="text" id="url_en" value="{{ isset($salesblock->getUrl->en) ? $salesblock->getUrl->en : old('url.en')}}" >
                {!! $errors->first('url[en]', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    </div>
</div>

<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}} col-md-12">
    <label for="image" class="control-label">{{ 'Изображение' }}</label>
    <input class="form-control" name="image" type="file" id="image" value="{{ isset($salesblock->image) ? $salesblock->image : ''}}" >
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
    @if(isset($salesblock->image))
        <br>
        <img src="{{ \Config::get('constants.alias.cdn_url').$salesblock->image }}" alt="" style="max-width: 400px;"> 
        <br>
    @endif
</div>



<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>
