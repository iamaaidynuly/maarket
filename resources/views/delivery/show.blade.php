@extends('adminlte::layout.main', ['title' => 'Цена доставки'])
@section('content')
    @component('adminlte::page', ['title' => 'Цена доставки'])
        @component('adminlte::box')
            @include('flash-message')
            <div class="card-body">
                <br/>

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ route('deliveries.update', $delivery->id) }}"
                      accept-charset="UTF-8"
                      class="form-horizontal" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    <div class="form-group col-md-12{{ $errors->has('Цена') ? 'has-error' : ''}}">
                        <label for="price" class="control-label">{{ 'Цена' }}</label>
                        <input class="form-control" name="price" type="text" id="price"
                               value="{{ isset($delivery->price) ? $delivery->price : old('price')}}">
                        {!! $errors->first('url', '<p class="help-block">:message</p>') !!}

                    </div>

                    <div class="form-group col-md-12">
                        <input class="btn btn-primary" type="submit" value="{{ 'Сохранить' }}">
                    </div>

                </form>

            </div>
        @endcomponent
    @endcomponent
@endsection
