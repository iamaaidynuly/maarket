@extends('adminlte::layout.main', ['title' => 'Редактировать'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактировать'])
    @component('adminlte::box')
        @include('flash-message')

            <div class="col-md-12">
                <a href="/admin/product " title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br>
                <br>
                {{-- <p><b>Добавить новое значение</b></p> --}}
            </div>

            {{-- <form action="/admin/admission/{{$product->id}}/store" method="POST">
                @csrf
                            <div class="form-group col-md-4 {{ $errors->has('title.ru') ? 'has-error' : ''}}">
                                <input class="form-control" name="phone_number" type="text" id="phone_number">
                            </div>

                <div class="col-md-2">
                    <button class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Добавить</button>
                </div>
                
            </form> --}}
            </div>

            <div class="col-md-12">
                <br>
                <p><b>Список значений</b></p>
            </div>
   
            @foreach($admission as $item)

                    <div class="container-fluid form-group">
                        <div class="row">
                            <form action="/admin/admission/{{$item->id}}/update" method="POST">
                                @csrf
                                <input name="region_id" type="text" id="order_id" value="{{$item->region_id}}" hidden>
                                <div class="col-md-3">
                                    <input type="text" name="phone_number" class="form-control" value="{{ $item->phone_number }}" disabled>
                                </div>
                        </form>
                            <div class="col-md-1">
                                <form action="/admin/admission/{{$item->id}}/delete" method="POST">
                                    @csrf
                                    <button class="btn btn-danger" style="width: 100%;">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div> 
                
            @endforeach
            <br>
        @endcomponent
    @endcomponent
@endsection

