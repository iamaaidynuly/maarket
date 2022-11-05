@extends('adminlte::layout.main', ['title' => 'Выгрузка Excel'])

@section('content')

    @component('adminlte::page', ['title' => 'Выгрузка Excel'])
        @component('adminlte::box')
            @include('flash-message')
             <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm" title="Загрузить Excel">
                <i class="fa fa-backward" aria-hidden="true"></i> Назад
            </a>
            <br/>
            <br/>
            <form class="form-horizontal" action="{{ route('user-export', $user->id) }}" method="post"
                  enctype="multipart/form-data"
                  style="border-bottom:1px solid #d3d3d3; margin-bottom:20px;padding-bottom:10px;">
                <div class="row">
                    <div class="col-md-3">
                        @csrf
                        <div class="mb-3">
                            <input class="form-control form-control-sm" type="date" name="from" required>
                        </div>
                        <div class="mb-3">
                            <input class="form-control form-control-sm" type="date" name="to" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-success" value="Выгрузить">
                    </div>
                </div>
            </form>
        @endcomponent
    @endcomponent
@endsection
