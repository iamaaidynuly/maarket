@extends('adminlte::layout.main', ['title' => 'Редактировать тип'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактировать тип'])
        @component('adminlte::box')
            <a href="{{ route('price-types.index') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
            <br />
            <br />

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('price-types.update', $type->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                @include ('price-type.form', ['formMode' => 'edit'])

            </form>
        @endcomponent
    @endcomponent

@endsection
