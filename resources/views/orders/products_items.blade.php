@extends('adminlte::layout.main', ['title' => 'Редактировать продукт'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактировать продукт'])
        @component('adminlte::box')
            @include('flash-message')

            <div class="col-md-12">
                <a href="/admin/orders " title="Назад">
                    <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад
                    </button>
                </a>
                <br>
                <br>
                <p><b>Добавить новое значение</b></p>
            </div>
            <form action="/admin/products-items/{{$order->id}}/store" method="POST">
                @csrf
                {{-- <div class="col-md-8">
                    <input type="text" name="filter_item[ru]" class="form-control" placeholder="{{ 'Наименование ru' }}" required>
                </div> --}}
                <div class="form-group col-md-3">
                    <select name="product_id" id="product_id" class="form-control js-example-basic-single" required>
                        <option value="">Выберите товар</option>
                        @foreach($product as $item)
                            <option value="{{$item->id}}"> --- {{ $item->getTitle->ru }}</option>
                        @endforeach
                    </select>

                    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-1">
                    <input type="text" name="count" class="form-control" placeholder="{{ 'Количество' }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="price" class="form-control" placeholder="{{ 'Цена' }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="funds_1_bonus" class="form-control" placeholder="{{ 'Акция 1' }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="funds_2_bonus" class="form-control" placeholder="{{ 'Акция 2' }}">
                </div>
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

            @foreach($order_products as $order_item)

                <div class="container-fluid form-group">
                    <div class="row">
                        <form action="/admin/products-items/{{$order_item->id}}/update" method="POST">
                            @csrf
                            <div class="form-group col-md-3">
                                <select name="product_id" id="product_id" class="form-control js-example-basic-single"
                                        required>
                                    <option value="">Выберите товар</option>
                                    @foreach($product as $item)
                                        <option value="{{$item->id}}"
                                                @if(isset($order_item->product_id) && $item->id == $order_item->product_id) selected @endif>
                                            --- {{ $item->getTitle->ru }}</option>
                                    @endforeach
                                </select>
                                <input name="order_id" type="text" id="order_id" value="{{$order_item->order_id}}"
                                       hidden>

                                {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-md-1">
                                <input type="text" name="count" class="form-control" value="{{ $order_item->count }}"
                                       placeholder="{{ 'Количество' }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="price" class="form-control" value="{{ $order_item->price }}"
                                       placeholder="{{ 'Цена' }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="funds_1_bonus" class="form-control" value="{{ $order_item->funds_1_bonus }}"
                                       placeholder="{{ 'Акция 1' }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="funds_2_bonus" class="form-control" value="{{ $order_item->funds_2_bonus }}"
                                       placeholder="{{ 'Акция 2' }}">
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-success" style="width: 100%;">Обновить</button>
                            </div>
                        </form>
                        <div class="col-md-1">
                            <form action="/admin/products-items/{{$order_item->id}}/delete" method="POST">
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

