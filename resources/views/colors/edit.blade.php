@extends('adminlte::layout.main', ['title' => 'Редактирование цвета'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактирование цвета'])
        @component('adminlte::box')
            <a href="{{ url('/admin/colors') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
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
                <form method="POST" action="{{ url('/admin/colors/' . $color->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    @include ('colors.form', ['formMode' => 'edit'])

                </form>
            </div>
        @endcomponent
    @endcomponent
@endsection
