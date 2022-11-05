@extends('adminlte::layout.main', ['title' => 'Редактирование страны'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактирование страны'])
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

            <form method="POST" action="{{ url('/admin/country/' . $country->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                @include ('country.form', ['formMode' => 'edit'])

            </form>
        @endcomponent
    @endcomponent

@endsection
