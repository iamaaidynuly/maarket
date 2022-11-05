@extends('adminlte::layout.main', ['title' => 'Фильтры'])

@section('content')
    @component('adminlte::page', ['title' => 'Фильтры'])
    @component('adminlte::box')
        @include('flash-message')
            <a href="{{ url('/admin/filters/create') }}" class="btn btn-success btn-sm" title="Добавить фильтр">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>

            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th><th>Наименование</th><th>Деиствия</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($filters as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->getTitle->ru }}</td>
                            <td>
                                <a href="{{ url('admin/filter-items/' . $item->id) }}" title="Просмотр фильтра"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр значений</button></a>
                                <a href="{{ url('/admin/filters/' . $item->id . '/edit') }}" title="Редактировать фильтр"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                                <form method="POST" action="{{ url('/admin/filters' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить фильтр" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $filters->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
