@extends('adminlte::layout.main', ['title' => 'Редактирование SEO'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактирование SEO'])
        @component('adminlte::box')

        <a href="{{ url('/admin/blogs') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
        <br>
        <br>
        <form method="POST" action="{{ url('/admin/blogs/seo/' .$blog->id.'/update') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}

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
                    <div class="form-group {{ $errors->has('meta_title.ru') ? 'has-error' : ''}}">
                        <label for="meta_title_ru" class="control-label">{{ 'Мета заголовок RU' }}</label>
                        <input class="form-control" name="meta_title[ru]" type="text" id="meta_title_ru" value="{{ isset($blog->metaTitle->ru) ? $blog->metaTitle->ru : old('meta_title.ru')}}">
                        {!! $errors->first('meta_title.ru', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('content.ru') ? 'has-error' : ''}}">
                        <label for="content" class="control-label">{{ 'Мета описание RU' }}</label>
                        <input class="form-control" name="meta_description[ru]" type="text" id="content" value="{{ isset($blog->metaDesc->ru) ? $blog->metaDesc->ru : old('meta_description.ru')}}" >
                        {!! $errors->first('content.ru', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            
                <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                    <div class="form-group {{ $errors->has('meta_title.en') ? 'has-error' : ''}}">
                        <label for="title" class="control-label">{{ 'Мета заголовок EN' }}</label>
                        <input class="form-control" name="meta_title[en]" type="text" id="title" value="{{ isset($blog->metaTitle->en) ? $blog->metaTitle->en : old('meta_title.en')}}" >
                        {!! $errors->first('meta_title.en', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('meta_description.en') ? 'has-error' : ''}}">
                        <label for="meta_description_en" class="control-label">{{ 'Мета описание EN' }}</label>
                        <input class="form-control" name="meta_description[en]" type="text" id="meta_description_en" value="{{ isset($blog->metaDesc->en) ? $blog->metaDesc->en : old('meta_description.en')}}" >
                        {!! $errors->first('meta_description.en', '<p class="help-block">:message</p>') !!}
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