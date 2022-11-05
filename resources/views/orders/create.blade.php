@extends('adminlte::layout.main', ['title' => 'Добавление заказа'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавление заказа'])
        @component('adminlte::box')

            <div class="md-12">
                <a href="{{ url('/admin/orders') }}" title="Назад">
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

                <form method="POST" action="{{ url('/admin/orders') }}" accept-charset="UTF-8" class="form-horizontal"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @include ('orders.form', ['formMode' => 'create'])

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
        })
    </script>
@endpush
