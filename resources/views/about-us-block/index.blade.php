@if($slug== 'about')
    <?php $text = 'О нас'; ?>
@elseif($slug == 'loyalty')
    <?php $text = 'Программа лояльности'; ?>
@elseif($slug == 'cooperation')
    <?php $text = 'Сотрудничество'; ?>
@elseif($slug == 'delivery')
    <?php $text = 'Доставка и самовывоз'; ?>
@elseif($slug == 'payment')
    <?php $text = 'Оплата'; ?>
@elseif($slug == 'return')
    <?php $text = 'Возврат'; ?>
@elseif($slug == 'faq')
    <?php $text = 'Частые вопросы'; ?>
@elseif($slug == 'banner')
    <?php $text = 'Баннер'; ?>
@elseif($slug == 'promocode')
    <?php $text = 'Промокод'; ?>
@elseif($slug == 'contacts')
    <?php $text = 'Страница Контакты'; ?>
@elseif($slug == 'offer')
    <?php $text = 'Оферта'; ?>
@elseif($slug == 'confidentiality')
    <?php $text = 'Конфиденциальность'; ?>
@elseif($slug == 'personal_data')
    <?php $text = 'Политика обработки персональных данных'; ?>
@endif


@section('content')
@extends('adminlte::layout.main', ['title' => $text])
    @component('adminlte::page', ['title' => $text])

        @component('adminlte::box')
            @include('flash-message')
            <form method="POST" action="{{ url('/admin/about-us-block') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
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
                <div class="tab-content col-md-12" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade active in" id="custom-tabs-one-ru" role="tabpanel" aria-labelledby="custom-tabs-one-ru-tab">
                        @if($slug!= 'faq' && $slug!='promocode')
                        <div class="form-group {{ $errors->has('title.ru') ? 'has-error' : ''}}">
                            <label for="title_ru" class="control-label">{{ 'Заголовок RU' }}</label>
                            <input class="form-control" name="title[ru]" type="text" id="title_ru" value="{{ isset($aboutusblock->getTitle->ru) ? $aboutusblock->getTitle->ru: old('title.ru')}}" >
                            {!! $errors->first('title.ru', '<p class="help-block">:message</p>') !!}
                        </div>
                        @endif
                        
                        <div class="form-group {{ $errors->has('description.ru') ? 'has-error' : ''}}">
                            <label for="description_ru" class="control-label">{{ 'Описание Ru' }}</label>            
                            <textarea class="form-control" name="description[ru]" id="description_ru" rows="10" required>{{ isset($aboutusblock->getDescription->ru) ? $aboutusblock->getDescription->ru : old('description.ru')}}</textarea>
                            {!! $errors->first('description.ru', '<p class="help-block">:message</p>') !!}
                        </div>


                    </div>

                    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
                        @if($slug!= 'faq')
                        <div class="form-group {{ $errors->has('title.en') ? 'has-error' : ''}}">
                            <label for="title_en" class="control-label">{{ 'Заголовок EN' }}</label>
                            <input class="form-control" name="title[en]" type="text" id="title_en" value="{{ isset($aboutusblock->getTitle->en) ? $aboutusblock->getTitle->en : old('content.en')}}" >
                            {!! $errors->first('title.en', '<p class="help-block">:message</p>') !!}
                        </div>
                        @endif
                        
                        <div class="form-group {{ $errors->has('description.en') ? 'has-error' : ''}}">
                            <label for="description_en" class="control-label">{{ 'Описание EN' }}</label>            
                            <textarea class="form-control" name="description[en]" id="description_en" rows="10">{{ isset($aboutusblock->getDescription->en) ? $aboutusblock->getDescription->en : old('description.en')}}</textarea>
                            {!! $errors->first('description.en', '<p class="help-block">:message</p>') !!}
                        </div>


                    </div>

                    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
                        @if($slug!= 'faq')
                        <div class="form-group {{ $errors->has('title.kz') ? 'has-error' : ''}}">
                            <label for="title_kz" class="control-label">{{ 'Заголовок KZ' }}</label>
                            <input class="form-control" name="title[kz]" type="text" id="title_kz" value="{{ isset($aboutusblock->getTitle->kz) ? $aboutusblock->getTitle->kz : old('content.kz')}}" >
                            {!! $errors->first('title.kz', '<p class="help-block">:message</p>') !!}
                        </div>
                        @endif
                        
                        <div class="form-group {{ $errors->has('description.kz') ? 'has-error' : ''}}">
                            <label for="description_kz" class="control-label">{{ 'Описание KZ' }}</label>            
                            <textarea class="form-control" name="description[kz]" id="description_kz" rows="10">{{ isset($aboutusblock->getDescription->kz) ? $aboutusblock->getDescription->kz : old('description.kz')}}</textarea>
                            {!! $errors->first('description.en', '<p class="help-block">:message</p>') !!}
                        </div>


                    </div>
                    @if($slug== 'banner')
                    <div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
                        <label for="url" class="control-label">{{ 'Ссылка' }}</label>
                        <input class="form-control" name="url" type="text" id="url" value="{{ isset($aboutusblock->url) ? $aboutusblock->url : old('url')}}" >
                        {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('image_mobile') ? 'has-error' : ''}}">
                        <label for="image_mobile" class="control-label">{{ 'Изображение(mobile)' }}</label>
                        <input class="form-control" name="image_mobile" type="file" id="image_mobile" value="{{ isset($aboutusblock->image_mobile) ? $aboutusblock->image_mobile : ''}}" >
                        {!! $errors->first('image_mobile', '<p class="help-block">:message</p>') !!}
                    </div>
                    @endif
                    <input type="text" hidden value="{{ isset($slug) ? $slug : ''}}" name="slug">
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                        <label for="image" class="control-label">{{ 'Изображение(desktop)' }}</label>
                        <input class="form-control" name="image" type="file" id="image" value="{{ isset($aboutusblock->image) ? $aboutusblock->image : ''}}" >
                        {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
                    </div>
                    @if (isset($aboutusblock->image))
                    <div class="form-group">
                        <img src="{{ \Config::get('constants.alias.cdn_url').$aboutusblock->image }}" alt="" style="width:400px;max-width:100%">
                    </div> 
                    @endif

                    
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="{{ 'Сохранить' }}">
                </div>
                </div>
    
            </form>



        @endcomponent
    @endcomponent             
@endsection
@push('scripts')
            <script src="/ckeditor/ckeditor.js"></script>
            <script>
                CKEDITOR.replace( 'description_ru' );
                CKEDITOR.replace( 'description_kz' );
                CKEDITOR.replace( 'description_en' );
                CKEDITOR.replace( 'short_description_ru' );
                CKEDITOR.replace( 'short_description_kz' );
                CKEDITOR.replace( 'short_description_en' );
            </script>
@endpush  
















{{-- 



@extends('adminlte::layout.main', ['title' => 'Блоки страницы о нас'])

@section('content')
    @component('adminlte::page', ['title' => 'Блоки страницы о нас'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{ url('/admin/about-us-block/create') }}" class="btn btn-success btn-sm" title="Добавить блок">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th><th>Изображение</th><th>Описание</th><th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($aboutusblock as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ \Config::get('constants.alias.cdn_url').$item->image }}" alt="" style="max-width: 300px;"> </td><td>{{ $item->getContent->ru }}</td>
                            <td>
                                <a href="{{ url('/admin/about-us-block/' . $item->id . '/edit') }}" title="Редактировать блок"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
                                <form method="POST" action="{{ url('/admin/about-us-block' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить блок" onclick="return confirm(&quot;Подтвердить удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $aboutusblock->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection --}}
