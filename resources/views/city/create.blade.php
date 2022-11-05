@extends('adminlte::layout.main', ['title' => 'Добавить город'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавить город'])
        @component('adminlte::box')
            <a href="{{ url('/admin/city') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
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
                <form method="POST" action="{{ url('/admin/city') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @include ('city.form', ['formMode' => 'create'])

                </form>
            </div>
        @endcomponent
    @endcomponent
@endsection
