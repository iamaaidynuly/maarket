@extends('adminlte::layout.main', ['title' => 'Главная'])

@section('content')
    @component('adminlte::page', ['title' => 'Страница администратора'])
        @component('adminlte::box')
            Вы удачно авторизовались!
        @endcomponent
    @endcomponent
@endsection
