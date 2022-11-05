@extends('adminlte::layout.main', ['title' => 'Добавить сертификат'])
@section('content')
    @component('adminlte::page', ['title' => 'Добавить сертификат'])
        @component('adminlte::box')
            @include('flash-message')
            <div class="card-body">
                <a href="{{route('certificates.index')}}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
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
                    <form method="POST" action="{{ route('certificates.store') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group col-md-12 {{ $errors->has('city_id') ? 'has-error' : ''}}">
                            <label for="image" class="control-label">{{ 'Выберите фотографию:' }}</label>
                            <input type="file" name="image" class="form-control" id="image" required>
                        </div>

                        <div class="form-group col-md-12">
                            <input class="btn btn-primary" type="submit" value="Принять">
                        </div>

                    </form>
                </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
