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
            <div class="form-group col-md-6 {{ $errors->has('name.ru') ? 'has-error' : ''}}">
                <label for="name_ru" class="control-label">{{ 'Имя Ru' }}</label>
                <input class="form-control" name="name[ru]" type="text" id="name_ru" value="{{ isset($statustype->name) ? $statustype->getName->ru : old('name.ru')}}" required>
                {!! $errors->first('name.ru', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="row">
            <div class="form-group col-md-6 {{ $errors->has('name.en') ? 'has-error' : ''}}">
                <label for="name_en" class="control-label">{{ 'Имя EN' }}</label>
                <input class="form-control" name="name[en]" type="text" id="name_en" value="{{ isset($statustype->name) ? $statustype->getName->en : old('name.en')}}" >
                {!! $errors->first('name.en', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
        <div class="row">
            <div class="form-group col-md-6 {{ $errors->has('name.kz') ? 'has-error' : ''}}">
                <label for="name_kz" class="control-label">{{ 'Имя KZ' }}</label>
                <input class="form-control" name="name[kz]" type="text" id="name_kz" value="{{ isset($statustype->name) ? $statustype->getName->kz : old('name.kz')}}" >
                {!! $errors->first('name.kz', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>
