@extends('adminlte::layout.main', ['title' => 'Добавить блок'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавить блок'])
        @component('adminlte::box')
            <a href="{{ url('/admin/sales-block') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
            <br />
            <br />

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ url('/admin/sales-block') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}

                @include ('sales-block.form', ['formMode' => 'create'])

            </form>
        @endcomponent
    @endcomponent
@endsection
