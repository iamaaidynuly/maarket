@extends('adminlte::layout.main', ['title' => 'Добавить тип цены'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавить тип цены'])
        @component('adminlte::box')
            <a href="{{ route('product-price-types', $product->id) }}" title="Назад">
                <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад
                </button>
            </a>
            <br/>
            <br/>

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="col-md-12">
                <form method="POST" action="{{ route('store-price-type') }}" accept-charset="UTF-8" class="form-horizontal"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="product" value="{{$product->id}}">
                    <div class="form-group">
                        <label for="price_type_id">Выберите тип:</label>
                        <select name="price_type_id" id="price_type_id" class="form-control">
                            <option value="">Выберите тип:</option>
                            @foreach($types as $type)
                                @if(!in_array($type->id, $productPriceTypes))
                                    <option value="{{$type->id}}">{{ $type->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Цена:</label>
                        <input type="text" name="price" id="price" class="form-control">
                    </div>
                    <button class="btn btn-success btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Сохранить</button>
                </form>
            </div>
        @endcomponent
    @endcomponent
@endsection
