@extends('adminlte::layout.main', ['title' => 'Редактирование SEO'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактирование SEO'])
        @component('adminlte::box')

        <a href="{{ url('/admin/product') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
        <br>
        <br>
        <form method="POST" action="{{ url('/admin/product/seo/' .$product->id.'/update') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}

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
                        <input class="form-control" name="meta_title[ru]" type="text" id="meta_title_ru" value="{{ isset($product->metaTitle->ru) ? $product->metaTitle->ru : old('meta_title.ru')}}">
                        {!! $errors->first('meta_title.ru', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('content.ru') ? 'has-error' : ''}}">
                        <label for="content" class="control-label">{{ 'Мета описание RU' }}</label>
                        <input class="form-control" name="meta_description[ru]" type="text" id="content" value="{{ isset($product->metaDesc->ru) ? $product->metaDesc->ru : old('meta_description.ru')}}" >
                        {!! $errors->first('content.ru', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            
                <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
                    <div class="form-group {{ $errors->has('meta_title.en') ? 'has-error' : ''}}">
                        <label for="title" class="control-label">{{ 'Мета заголовок EN' }}</label>
                        <input class="form-control" name="meta_title[en]" type="text" id="title" value="{{ isset($product->metaTitle->en) ? $product->metaTitle->en : old('meta_title.en')}}" >
                        {!! $errors->first('meta_title.en', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('meta_description.en') ? 'has-error' : ''}}">
                        <label for="meta_description_en" class="control-label">{{ 'Мета описание EN' }}</label>
                        <input class="form-control" name="meta_description[en]" type="text" id="meta_description_en" value="{{ isset($product->metaDesc->en) ? $product->metaDesc->en : old('meta_description.en')}}" >
                        {!! $errors->first('meta_description.en', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
                    <div class="form-group {{ $errors->has('meta_title.kz') ? 'has-error' : ''}}">
                        <label for="meta_title_kz" class="control-label">{{ 'Мета заголовок KZ' }}</label>
                        <input class="form-control" name="meta_title[kz]" type="text" id="meta_title_kz" value="{{ isset($product->metaTitle->kz) ? $product->metaTitle->kz : old('meta_title.kz')}}" >
                        {!! $errors->first('meta_title.kz', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('meta_description.kz') ? 'has-error' : ''}}">
                        <label for="meta_description_kz" class="control-label">{{ 'Мета описание KZ' }}</label>
                        <input class="form-control" name="meta_description[kz]" type="text" id="meta_description_kz" value="{{ isset($product->metaDesc->kz) ? $product->metaDesc->kz : old('meta_description.kz')}}" >
                        {!! $errors->first('meta_description.kz', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="{{ 'Сохранить' }}">
            </div>


        </form>

        @endcomponent
    @endcomponent
@endsection