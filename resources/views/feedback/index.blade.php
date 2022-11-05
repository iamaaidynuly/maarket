@extends('adminlte::layout.main', ['title' => 'Обратная связь'])

@section('content')
    @component('adminlte::page', ['title' => 'Обратная связь'])
        @component('adminlte::box')
            @include('flash-message')

            <a href="{{ url('/admin/feedback/create') }}" class="btn btn-success btn-sm" title="Добавить">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Имя</th>
                        <th>Логин</th>
                        <th>Тема</th>
                        <th>Текст</th>
                        <th>Деиствия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($feedback as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone_number }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->text }}</td>
                            <td>
                                <a href="{{ url('/admin/feedback/' . $item->id) }}" title="Посмотреть">
                                    <button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                        Просмотр
                                    </button>
                                </a>
                                <a href="{{ url('/admin/feedback/' . $item->id . '/edit') }}" title="Редактировать">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                              aria-hidden="true"></i> Редактировать
                                    </button>
                                </a>

                                <form method="POST" action="{{ url('/admin/feedback' . '/' . $item->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить"
                                            onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <div class="pagination-wrapper"></div>
            </div>
        @endcomponent
    @endcomponent
@endsection
