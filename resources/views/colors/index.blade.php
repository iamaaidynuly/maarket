@extends('adminlte::layout.main', ['title' => 'Цвета'])

@section('content')
    
    @component('adminlte::page', ['title' => 'Цвета'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{ url('/admin/colors/create') }}" class="btn btn-success btn-sm" title="Добавить новый цвет">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th><th>Название Ru</th><th>Название En</th><th>Название Kz</th><th>Цвет</th><th>Деиствия</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($colors as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->getTitle->ru }}</td><td>{{ $item->getTitle->en }}</td><td>{{ $item->getTitle->kz }}</td><td><div style="width:20px; height:20px;background:{{$item->code}};"></div></td>
                            <td>
                                <a href="{{ url('/admin/colors/' . $item->id . '/edit') }}" title="Редактировать цвет"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
                                <form method="POST" action="{{ url('/admin/colors' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить цвет" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $colors->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
