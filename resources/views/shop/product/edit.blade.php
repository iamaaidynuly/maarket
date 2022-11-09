@extends('adminlte::layout.main', ['title' => 'Редактирование товара'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактирование товара'])
        @component('adminlte::box')
            <a href="{{ route('products.index') }}" title="Назад">
                <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад
                </button>
            </a>
            <br/>
            <br/>
            @include('flash-message')
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="POST" action="{{ route('products.update', $shopProduct->id) }}" accept-charset="UTF-8"
                  class="form-horizontal" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <input type="hidden" name="shop_id" value="{{$magazin->id}}">

                <div class="form-group col-md-12 {{ $errors->has('Продукт') ? 'has-error' : '' }}">
                    <label for="product" class="control-label">{{ 'Продукт' }}</label>
                    <select name="product" id="product" class="form-control">
                        @foreach($products as $product)
                            @if(isset($product->getTitle))
                                <option value="{{$product->id}}"
                                        @if($shopProduct->product_id == $product->id) selected @endif>{{$product->id}}
                                    .{{$product->getTitle->ru}},
                                    Цена:{{$product->current_price}}
                                </option>
                            @else
                                <option value="{{$product->id}}"
                                        @if($shopProduct->product_id == $product->id) selected @endif>
                                    Название отсутствует
                                </option>
                            @endif
                        @endforeach
                    </select>
                    {!! $errors->first('product', '<p class="help-block">:message</p>') !!}
                </div>

                <div class="form-group col-md-12 {{ $errors->has('Цена') ? 'has-error' : '' }}">
                    <label for="price" class="control-label">{{ 'Цена' }}</label>
                    <input type="text" class="form-control" name="price" id="price" value="{{$shopProduct->price}}">
                </div>

                <div class="form-group col-md-12 {{ $errors->has('В наличии') ? 'has-error' : '' }}">
                    <label for="available" class="control-label">{{ 'В наличии' }}</label>
                    <select name="available" id="available" class="form-control">
                        <option value="1" @if($shopProduct->available == true) selected @endif>Есть</option>
                        <option value="0" @if($shopProduct->available == false) selected @endif>Нет</option>
                    </select>
                    {!! $errors->first('available', '<p class="help-block">:message</p>') !!}
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit">
                    </div>
                </div>
            </form>
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
                    url: "/admin/get-filters?category_id=" + val,
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

            $(document).ready(function () {
                $('.js-example-basic-multiple').select2();
                $('.js-example-basic-single').select2();
                $('#brand_id').change(function () {
                    console.log('select');
                    let val = $('#brand_id :selected').val();
                    $.ajax({
                        method: "GET",
                        url: "/admin/get-brands?brand_id=" + val,
                        success: (response) => {
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

            $('.delete-img-product').click(function () {
                console.log('click');
                let val = $(this).attr('data-id');
                $.ajax({
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/admin/product-delete-img/" + val,
                    success: (response) => {
                        if (response == 1) {
                            $(this).parent().parent().remove();
                        }
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })
                console.log(val);
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
