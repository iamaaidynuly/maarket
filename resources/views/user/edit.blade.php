@extends('adminlte::layout.main', ['title' => 'Изменение пароля'])

@section('content')
    @component('adminlte::page', ['title' => 'Изменение пароля'])
        @component('adminlte::box')
            @include('flash-message')
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="col-md-12">
                <form method="POST" action="{{ url('/admin/save') }}" accept-charset="UTF-8" class="form-horizontal"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="password">Введите новый пароль</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Повторите пароль</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               id="password_confirmation">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="сохранить">
                    </div>
                </form>
            </div>
        @endcomponent
    @endcomponent
@endsection
