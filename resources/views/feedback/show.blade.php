@extends('adminlte::layout.main', ['title' => 'Просмотр'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр'])
        @component('adminlte::box')
            <a href="{{ url('/admin/feedback') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
            <a href="{{ url('/admin/feedback/' . $feedback->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

            <form method="POST" action="{{ url('admin/feedback' . '/' . $feedback->id) }}" accept-charset="UTF-8" style="display:inline">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
            </form>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr><th> Имя </th><td> {{ $feedback->name }} </td></tr>
                        <tr>
                            <th> Номер телефона </th>
                            <td>{{$feedback->phone_number }}</td>
                        </tr>
                        <tr>
                            <th> Почта </th>
                            <td> {{$feedback->email}} </td>
                        </tr>
                        <tr><th> Наименование организации </th><td> {{ $feedback->company }} </td></tr></tr>
                        <tr><th> Комментарии </th><td> {{ $feedback->comment }} </td></tr>
                    </tbody>
                </table>
            </div>
        @endcomponent
    @endcomponent
@endsection
