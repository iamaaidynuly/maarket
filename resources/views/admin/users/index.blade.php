@extends('adminlte::layout.main', ['title' => 'Пользователи'])

@section('content')
    @component('adminlte::page', ['title' => 'Пользователи'])
        @component('adminlte::box')
            @include('flash-message')
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('users.create') }}" class="btn btn-success btn-sm" title="Добавить">
                        <i class="fa fa-plus" aria-hidden="true"></i> Добавить
                    </a>
                    <form action="{{route('users.index')}}" method="get" accept-charset="UTF-8"
                          style="display:inline">
                        {{ csrf_field() }}
                        <input type="text" name="text" id="text" class="form-group">
                        <button type="submit" class="btn btn-info btn-sm">Искать</button>
                    </form>
                </div>
                {{--                <div class="col-md-5">--}}
                {{--                    <div class="form-group">--}}
                {{--                        <form action="{{route('users.index')}}" method="get" accept-charset="UTF-8"--}}
                {{--                              style="display:inline">--}}
                {{--                            {{ csrf_field() }}--}}
                {{--                            <input type="text" name="text" id="text" class="form-group">--}}
                {{--                            <button type="submit" class="btn btn-info btn-sm">Искать</button>--}}
                {{--                        </form>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
            <br>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Отчество</th>
                        <th>Логин</th>
                        <th>Номер</th>
                        <th>Тип</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->lname }}</td>
                            <td>{{ $item->sname }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone_number }}</td>
                            <td>
                                @if($item->type == 'individual')
                                    Физ.лицо
                                @else
                                    Юр.лицо
                                @endif
                            </td>

                            <td>
                                <form method="POST" action="{{ route('users.destroy', $item->id)  }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <a class="btn btn-sm btn-primary "
                                       href="{{ route('users.show',$item->id) }}"><i
                                            class="fa fa-fw fa-eye"></i></a>
                                    <a class="btn btn-sm btn-success"
                                       href="{{ route('users.edit',$item->id) }}"><i
                                            class="fa fa-fw fa-edit"></i></a>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить бренд"
                                            onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div
                    class="pagination-wrapper"> {!! $users->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
