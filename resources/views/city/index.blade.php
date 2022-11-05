@extends('adminlte::layout.main', ['title' => 'Города'])

@section('content')
    
    @component('adminlte::page', ['title' => 'Города'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{ url('/admin/city/create') }}" class="btn btn-success btn-sm" title="Добавить страну">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th><th>Название Ru</th> <th>Название Kz</th><th>Деиствия</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($city as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->getTitle->ru }}</td>
                            <td>{{ $item->getTitle->kz }}</td>
                            <td>
                                <a href="{{ url('/admin/city/' . $item->id . '/edit') }}" title="Редактировать город"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                                <form method="POST" action="{{ url('/admin/city' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить город" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $city->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
