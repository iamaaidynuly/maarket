@extends('adminlte::layout.main', ['title' => 'Добавить страну'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавить страну'])
        @component('adminlte::box')
            <a href="{{ url('/admin/country') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
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
                <form method="POST" action="{{ url('/admin/country') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @include ('country.form', ['formMode' => 'create'])

                </form>
            </div>
        @endcomponent
    @endcomponent
@endsection
