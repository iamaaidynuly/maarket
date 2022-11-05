@extends('adminlte::layout.main', ['title' => 'Добавить слайд'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавить слайд'])
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

        <form method="POST" action="{{ url('/admin/sales-block/' . $salesblock->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}

            @include ('sales-block.form', ['formMode' => 'edit'])

        </form>
        
        @endcomponent
    @endcomponent
@endsection
