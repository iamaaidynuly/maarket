<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
    <li class="nav-item active">
        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Русский</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Казахский</a>
    </li>
</ul>

<div class="tab-content" id="custom-tabs-two-tabContent">
    <div class="tab-pane fade active in" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
        <div class="row">
            <div class="form-group col-md-6 {{ $errors->has('title.ru') ? 'has-error' : ''}}">
                <label for="title_ru" class="control-label">{{ 'Название города Ru' }}</label>
                <input class="form-control" name="title[ru]" type="text" id="title_ru" value="{{ isset($city->title) ? $city->getTitle->ru : old('title.ru')}}" required>
                {!! $errors->first('title.ru', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
        <div class="row">
            <div class="form-group col-md-6 {{ $errors->has('title.kz') ? 'has-error' : ''}}">
                <label for="title_kz" class="control-label">{{ 'Название города Kz' }}</label>
                <input class="form-control" name="title[kz]" type="text" id="title_kz" value="{{ isset($city->title) ? $city->getTitle->kz : old('title.kz')}}" >
                {!! $errors->first('title.kz', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>

