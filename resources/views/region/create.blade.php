@extends('adminlte::layout.main', ['title' => 'Добавить область'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавить область'])
        @component('adminlte::box')
            <a href="{{ url('/admin/region') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
            <br />
            <br />

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="col-md-12">
                <form method="POST" action="{{ url('/admin/region') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @include ('region.form', ['formMode' => 'create'])

                </form>
            </div>
        @endcomponent
    @endcomponent
@endsection
