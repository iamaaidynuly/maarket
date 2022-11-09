@extends('adminlte::layout.main', ['title' => 'Добавить товар'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавить товар'])
        @component('adminlte::box')
            <a href="{{ route('products.index') }}" title="Назад">
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
                <form method="POST" action="{{ route('products.store') }}" accept-charset="UTF-8"
                      class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="shop_id" value="{{$magazin->id}}">

                    <div class="form-group col-md-12 {{ $errors->has('Продукт') ? 'has-error' : '' }}">
                        <label for="product" class="control-label">{{ 'Продукт' }}</label>
                        <select name="product" id="product" class="form-control">
                            @foreach($products as $product)
                                @if(isset($product->getTitle))
                                    <option value="{{$product->id}}">{{$product->id}}.{{$product->getTitle->ru}},Цена:{{$product->current_price}}</option>
                                @else
                                    <option value="{{$product->id}}">Название отсутствует</option>
                                @endif
                            @endforeach
                        </select>
                        {!! $errors->first('product', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group col-md-12 {{ $errors->has('Цена') ? 'has-error' : '' }}">
                        <label for="price" class="control-label">{{ 'Цена' }}</label>
                        <input type="text" class="form-control" name="price" id="price">
                    </div>

                    <div class="form-group col-md-12 {{ $errors->has('В наличии') ? 'has-error' : '' }}">
                        <label for="available" class="control-label">{{ 'В наличии' }}</label>
                        <select name="available" id="available" class="form-control">
                            <option value="1">Есть</option>
                            <option value="0">Нет</option>
                        </select>
                        {!! $errors->first('available', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit">
                        </div>
                    </div>
                </form>
            </div>
        @endcomponent
    @endcomponent
@endsection
@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-single').select2();
            $('#category_id').change(function () {
                console.log('select');
                let val = $('#category_id :selected').val();
                $.ajax({
                    method: "GET",
                    url: "/get-filters?category_id=" + val,
                    success: (response) => {
                        $('#filters').find('optgroup').remove().end();
                        $("#filters").prepend(response);
                        $('#filters').select2();
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })


            });
        });
        // $(".list").prepend("<option value="1">Фильтр 1</option><option value="2">Фильтр 2</option>");

    </script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-single').select2();
            $('#size_id').change(function () {
                console.log('select');
                let val = $('#size_id :selected').val();
                $.ajax({
                    method: "GET",
                    url: "/admin/get-sizes?size_id=" + val,
                    success: (response) => {
                        console.log(response);
                        $('#size_items').find('option').remove().end();
                        $("#size_items").prepend(response);
                        $('#size_items').select2();
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })


            });
        });
        // $(".list").prepend("<option value="1">Фильтр 1</option><option value="2">Фильтр 2</option>");

    </script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-single').select2();
            $('#brand_id').change(function () {
                console.log('select');
                let val = $('#brand_id :selected').val();
                $.ajax({
                    method: "GET",
                    url: "/get-brands?brand_id=" + val,
                    success: (response) => {
                        console.log(response);
                        $('#brand_items').find('option').remove().end();
                        $("#brand_items").prepend(response);
                        $('#brand_items').select2();
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })


            });
        });
        // $(".list").prepend("<option value="1">Фильтр 1</option><option value="2">Фильтр 2</option>");

    </script>
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description_ru');
        CKEDITOR.replace('description_en');
        CKEDITOR.replace('description_kz');
        CKEDITOR.replace('specifications_ru');
        CKEDITOR.replace('specifications_en');
        CKEDITOR.replace('specifications_kz');

    </script>
@endpush
