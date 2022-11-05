@extends('adminlte::layout.main', ['title' => 'Акции'])

@section('content')
    @component('adminlte::page', ['title' => 'Акции'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{ url('/admin/sales-block/create') }}" class="btn btn-success btn-sm" title="Добавить блок">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>

            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th><th>Заголовок ru</th><th>Заголовок en</th><th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($salesblock as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->getTitle->ru }}</td><td>{{ $item->getTitle->en }}</td>
                            <td>
                                <a href="{{ url('/admin/sales-block/' . $item->id) }}" title="Просмотр блока"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр</button></a>
                                <a href="{{ url('/admin/sales-block/' . $item->id . '/edit') }}" title="Редактирование блока"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                                <form method="POST" action="{{ url('/admin/sales-block' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить блок" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $salesblock->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
