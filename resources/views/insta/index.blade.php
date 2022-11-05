@extends('adminlte::layout.main', ['title' => 'Инстаграм'])

@section('content')
    @component('adminlte::page', ['title' => 'Инстаграм'])
    @component('adminlte::box')
        @include('flash-message')
    
            <a href="{{ url('/admin/insta/create') }}" class="btn btn-success btn-sm" title="Добавить">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Картинка</th><th>Ссылка</th><th>Деиствия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($insta as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td> <img src="{{ \Config::get('constants.alias.cdn_url').$item->image }}" alt="" style="max-width: 100px;"> </td>
                                        <td>{{ $item->link }}</td>
                                        <td>
                                            <a href="{{ url('/admin/insta/' . $item->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                                            <form method="POST" action="{{ url('/admin/insta' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm(&quot;Подтвердите удаление?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $insta->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>
        @endcomponent
    @endcomponent
@endsection
