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

                    @include ('shop.product.form', ['formMode' => 'create'])

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
