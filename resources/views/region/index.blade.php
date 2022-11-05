@extends('adminlte::layout.main', ['title' => 'Область'])

@section('content')
    
    @component('adminlte::page', ['title' => 'Область'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{ url('/admin/region/create') }}" class="btn btn-success btn-sm" title="Добавить область">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th><th>Название Ru</th><th>Город</th><th>Деиствия</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($region as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->getTitle->ru }}</td>
                            <td><a href="{{ url('admin/cities/' . $item->id) }}">{{ 'Редактировать город' }}</a></td>
                            <td>
                                <a href="{{ url('/admin/region/' . $item->id . '/edit') }}" title="Редактировать область"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                                <form method="POST" action="{{ url('/admin/region' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить область" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $region->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
