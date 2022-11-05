@extends('adminlte::layout.main', ['title' => 'Добавление пользователя'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавление пользователя'])
        @component('adminlte::box')

            <div class="md-12">
                <a href="{{ route('users.index') }}" title="Назад">
                    <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад
                    </button>
                </a>
                <br/>
                <br/>

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ route('users.store') }}" accept-charset="UTF-8" class="form-horizontal"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label for="name" class="control-label">{{ 'Имя' }}</label>
                        <input class="form-control" name="name" type="text" id="name"">
                        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('l_name') ? 'has-error' : ''}}">
                        <label for="l_name" class="control-label">{{ 'Фамилия' }}</label>
                        <input class="form-control" name="l_name" type="text" id="l_name">
                        {!! $errors->first('l_name', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group col-md-12 {{ $errors->has('phone') ? 'has-error' : ''}}">
                        <label for="phone_number" class="control-label">{{ 'Телефон' }}</label>
                        <input class="form-control" name="phone_number" type="text" id="phone_number">
                        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group col-md-12 {{ $errors->has('email') ? 'has-error' : ''}}">
                        <label for="email" class="control-label">{{ 'E-mail' }}</label>
                        <input class="form-control" name="email" type="text" id="email">
                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group col-md-12 {{ $errors->has('password') ? 'has-error' : ''}}">
                        <label for="password" class="control-label">{{ 'Пароль' }}</label>
                        <input class="form-control" name="password" type="password" id="password">
                        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group col-md-12 {{ $errors->has('type') ? 'has-error' : ''}}">
                        <label for="type" class="control-label">{{ 'Тип пользователя' }}</label>
                        <select class="form-control" name="type" id="type">
                            <option value="individual">Физ.лицо</option>
                            <option value="entity">Юр.лицо</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="type" class="control-label">{{ 'Прошел верификацию' }}</label>
                        <input type="checkbox" name="email_verified"
                               value="1">
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" type="submit"
                               value="{{ 'Сохранить' }}">
                    </div>


                </form>
            </div>
        @endcomponent
    @endcomponent
@endsection
@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-single').select2();
        })
    </script>
@endpush
