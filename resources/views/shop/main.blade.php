@extends('adminlte::layout.main', ['title' => 'Главная'])

@section('content')
    @component('adminlte::page', ['title' => 'Страница администратора'])
        @component('adminlte::box')
            @if(auth()->user())
                Вы удачно авторизовались как супер админ!
            @endif

            @if($magazin)
                Вы удачно авторизовались в свою админку <span style="color:darkolivegreen;font-weight:bold;">{{$magazin->getName->ru}}!</span>
            @endif
        @endcomponent
    @endcomponent
@endsection
