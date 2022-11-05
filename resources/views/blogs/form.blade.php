<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
    <li class="nav-item active">
        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Русский</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Английский</a>
    </li>
</ul>


<div class="tab-content" id="custom-tabs-two-tabContent">
    <div class="tab-pane fade active in" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
        <div class="form-group {{ $errors->has('title.ru') ? 'has-error' : ''}}">
            <label for="title_ru" class="control-label">{{ 'Наименование RU' }}</label>
            <input class="form-control" name="title[ru]" type="text" id="title_ru" value="{{ isset($blog->getTitle->ru) ? $blog->getTitle->ru : old('title.ru')}}" >
            {!! $errors->first('title.ru', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="content_ru" class="control-label">{{ 'Описание RU' }}</label>
            <textarea name="content[ru]" id="content_ru" rows="3" class="form-control">{{ isset($blog->getContent->ru) ? $blog->getContent->ru : old('content.ru')}}</textarea>
            {!! $errors->first('content.ru"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
        <div class="form-group {{ $errors->has('title.en') ? 'has-error' : ''}}">
            <label for="title_en" class="control-label">{{ 'Наименование EN' }}</label>
            <input class="form-control" name="title[en]" type="text" id="title_en" value="{{ isset($blog->getTitle->en) ? $blog->getTitle->en : old('title.en')}}" >
            {!! $errors->first('title.en', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content.en') ? 'has-error' : ''}}">
            <label for="content_ru" class="control-label">{{ 'Описание EN' }}</label>
            <textarea name="content[en]" id="content_en" rows="3" class="form-control">{{ isset($blog->getContent->en) ? $blog->getContent->en : old('content.en')}}</textarea>
            {!! $errors->first('content.en"', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="image" class="control-label">{{ 'Логотип (1300x550px)' }}</label>
    <input class="form-control" name="image" type="file" id="image" value="{{ isset($blog->image) ? $blog->image : ''}}" >
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
    
    @if(isset($blog->image))
        <br>
       <img src="{{ \Config::get('constants.alias.cdn_url').$blog->image }}" alt="" style="max-width: 400px;"> 
       <br>
    @endif
    
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Сохранить' : 'Добавить' }}">
</div>