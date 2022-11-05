@extends('adminlte::layout.main', ['title' => 'Редактировать область'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактировать область'])
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

            <form method="POST" action="{{ url('/admin/region/' . $region->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                @include ('region.form', ['formMode' => 'edit'])

            </form>
        @endcomponent
    @endcomponent

@endsection
