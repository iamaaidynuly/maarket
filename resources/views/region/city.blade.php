@extends('adminlte::layout.main', ['title' => 'Редактировать город'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактировать город'])
    @component('adminlte::box')
        @include('flash-message')

            <div class="col-md-12">
                <a href="/admin/region " title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br>
                <br>
                <p><b>Добавить новое значение</b></p>
            </div>

            <form action="/admin/cities/{{$region->id}}/store" method="POST">
                @csrf
                {{-- <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Русский</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Казахский</a>
                    </li>
                </ul> --}}


                {{-- <div class="tab-content" id="custom-tabs-two-tabContent"> --}}
                    {{-- <div class="tab-pane fade active in" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab"> --}}
                        {{-- <div class="row"> --}}
                            <div class="form-group col-md-4 {{ $errors->has('title.ru') ? 'has-error' : ''}}">
                                {{-- <label for="title_ru" class="control-label">{{ 'Название города Ru' }}</label> --}}
                                <input class="form-control" name="title[ru]" type="text" id="title_ru" placeholder="{{ 'Название города Ru' }}">
                            </div>
                        {{-- </div> --}}
                    {{-- </div> --}}
                
                    {{-- <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab"> --}}
                        {{-- <div class="row"> --}}
                            <div class="form-group col-md-4 {{ $errors->has('title.en') ? 'has-error' : ''}}">
                                {{-- <label for="title_kz" class="control-label">{{ 'Название города Kz' }}</label> --}}
                                <input class="form-control" name="title[en]" type="text" id="title_en" placeholder="{{ 'Название города En' }}">
                            </div>
                        {{-- </div> --}}
                    {{-- </div> --}}

                    {{-- <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab"> --}}
                        {{-- <div class="row"> --}}
                            <div class="form-group col-md-4 {{ $errors->has('title.kz') ? 'has-error' : ''}}">
                                {{-- <label for="title_kz" class="control-label">{{ 'Название города Kz' }}</label> --}}
                                <input class="form-control" name="title[kz]" type="text" id="title_kz" placeholder="{{ 'Название города Kz' }}">
                            </div>
                        {{-- </div> --}}
                    {{-- </div> --}}
                {{-- </div> --}}

                


                {{-- <div class="col-md-2">
                    <input type="text" name="count" class="form-control" placeholder="{{ 'Количество' }}" >
                </div>
                <div class="col-md-2">
                    <input type="text" name="price" class="form-control" placeholder="{{ 'Цена' }}" >
                </div> --}}
                <div class="col-md-2">
                    <button class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Добавить</button>
                </div>
                
            </form>

            
            <br/>
            <br/>
            <br>
            <div class="col-md-12">
                <br>
                <p><b>Список значений</b></p>
            </div>
   
            @foreach($city as $item)

                    <div class="container-fluid form-group">
                        <div class="row">
                            <form action="/admin/cities/{{$item->id}}/update" method="POST">
                                @csrf
                                <input name="region_id" type="text" id="order_id" value="{{$item->region_id}}" hidden>
                                <div class="col-md-3">
                                    <input type="text" name="title[ru]" class="form-control" value="{{ $item->getTitle->ru }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="title[en]" class="form-control" value="{{ $item->getTitle->en }}" >
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="title[kz]" class="form-control" value="{{ $item->getTitle->kz }}" >
                                </div>
                            <div class="col-md-2">
                                <button class="btn btn-success" style="width: 100%;">Обновить</button>
                            </div>
                        </form>
                            <div class="col-md-1">
                                <form action="/admin/cities/{{$item->id}}/delete" method="POST">
                                    @csrf
                                    <button class="btn btn-danger" style="width: 100%;">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div> 
                
            @endforeach
        @endcomponent
    @endcomponent
@endsection

