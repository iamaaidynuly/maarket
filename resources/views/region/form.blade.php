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
        <div class="row">
            <div class="form-group col-md-6 {{ $errors->has('title.ru') ? 'has-error' : ''}}">
                <label for="title_ru" class="control-label">{{ 'Название области Ru' }}</label>
                <input class="form-control" name="title[ru]" type="text" id="title_ru" value="{{ isset($region->title) ? $region->getTitle->ru : old('title.ru')}}" required>
                {!! $errors->first('title.ru', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="row">
            <div class="form-group col-md-6 {{ $errors->has('title.ru') ? 'has-error' : ''}}">
                <label for="title_en" class="control-label">{{ 'Название области En' }}</label>
                <input class="form-control" name="title[en]" type="text" id="title_en" value="{{ isset($region->title) ? $region->getTitle->en : old('title.en')}}">
                {!! $errors->first('title.en', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz">
        <div class="row">
            <div class="form-group col-md-6 {{ $errors->has('title.kz') ? 'has-error' : ''}}">
                <label for="title_kz" class="control-label">{{ 'Название области Kz' }}</label>
                <input class="form-control" name="title[kz]" type="text" id="title_kz" value="{{ isset($region->title) ? $region->getTitle->kz : old('title.kz')}}" >
                {!! $errors->first('title.kz', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>