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
        <div class="form-group {{ $errors->has('title.ru') ? 'has-error' : ''}}">
            <label for="title" class="control-label">{{ 'Заголовок RU' }}</label>
            <input class="form-control" name="title[ru]" type="text" id="title" value="{{ isset($category->getTitle->ru) ? $category->getTitle->ru : old('title.ru')}}" required>
            {!! $errors->first('title.ru', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content.ru') ? 'has-error' : ''}}">
            <label for="content" class="control-label">{{ 'Описание RU' }}</label>
            <input class="form-control" name="content[ru]" type="text" id="content" value="{{ isset($category->getContent->ru) ? $category->getContent->ru : old('content.ru')}}" >
            {!! $errors->first('content.ru', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="form-group {{ $errors->has('title.en') ? 'has-error' : ''}}">
            <label for="title" class="control-label">{{ 'Заголовок EN' }}</label>
            <input class="form-control" name="title[en]" type="text" id="title" value="{{ isset($category->getTitle->en) ? $category->getTitle->en : old('title.en')}}" >
            {!! $errors->first('title.en', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content.en') ? 'has-error' : ''}}">
            <label for="content" class="control-label">{{ 'Описание EN' }}</label>
            <input class="form-control" name="content[en]" type="text" id="content" value="{{ isset($category->getContent->en) ? $category->getContent->en : old('content.en')}}" >
            {!! $errors->first('content.en', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
        <div class="form-group {{ $errors->has('title.kz') ? 'has-error' : ''}}">
            <label for="title" class="control-label">{{ 'Заголовок KZ' }}</label>
            <input class="form-control" name="title[kz]" type="text" id="title" value="{{ isset($category->getTitle->kz) ? $category->getTitle->kz : old('title.kz')}}" >
            {!! $errors->first('title.kz', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content.kz') ? 'has-error' : ''}}">
            <label for="content" class="control-label">{{ 'Описание KZ' }}</label>
            <input class="form-control" name="content[kz]" type="text" id="content" value="{{ isset($category->getContent->kz) ? $category->getContent->kz : old('content.kz')}}" >
            {!! $errors->first('content.kz', '<p class="help-block">:message</p>') !!}
        </div>

    </div>
</div>

@if (!request('parent_id'))
<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="image" class="control-label">{{ 'Изображение' }}</label>
    <input class="form-control" name="image" type="file" id="image" value="{{ isset($category->image) ? $category->image : ''}}" >
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
    @if(isset($category->image))
        <img src="{{ \Config::get('constants.alias.cdn_url').$category->image}}" alt="" style="max-width: 300px;">
    @endif
</div>
@endif
<div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}" hidden>
    <label for="slug" class="control-label">{{ 'Slug' }}</label>
    <input class="form-control" name="slug" type="text" id="slug" value="{{ isset($category->slug) ? $category->slug : ''}}" >
    {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : ''}}" hidden>
    <label for="parent_id" class="control-label">{{ 'Parent Id' }}</label>
    <input class="form-control" name="parent_id" type="number" id="parent_id" value="{{ isset($category->parent_id) ? $category->parent_id : request('parent_id')}}" >
    {!! $errors->first('parent_id', '<p class="help-block">:message</p>') !!}
</div>


@if (!request('parent_id'))
    <div class="form-group {{ $errors->has('position') ? 'has-error' : ''}}">
        <label for="position" class="control-label">{{ 'Отображение на главной странице' }}</label>
        <select name="position" id="position" class="form-control">
            <option value = "0">Не отображать</option>
            {{-- <option value="top" {{ isset($category->position) ? $category->position : ''}}>Верхняя часть</option> --}}
            <option value="1">Отображать</option>
        </select>
        {!! $errors->first('position', '<p class="help-block">:message</p>') !!}
    </div>

@endif

<div class="form_group" style="margin-bottom:15px;">
    <label for="filters" class="control-label">{{ 'Фильтры' }}</label>
    <select id="filters" class="form-control js-example-basic-multiple" name="filters[]" multiple="multiple" required>
        @foreach($filters as $filter)
            <option value="{{$filter->id}}" @if(in_array($filter->id, $filter_arr)) selected @endif>{{$filter->getTitle->ru}}</option>
        @endforeach
    </select>
</div>
<div id='check_slug' class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
    <label for="slug" class="control-label">{{ 'Ссылка' }}</label>
    <input class="form-control" name="slug" type="text" id="slug" value="{{ isset($category->slug) ? $category->slug : ''}}" >
    <p class="help-block" style="display: none;">Ссылка должна быть уникальной</p>
</div>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Сохранить' : 'Добавить' }}">
</div>
