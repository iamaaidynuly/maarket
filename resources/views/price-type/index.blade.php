@extends('adminlte::layout.main', ['title' => 'Виды цен'])

@section('content')

    @component('adminlte::page', ['title' => 'Виды цен'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{ route('price-types.create')}}" class="btn btn-success btn-sm" title="Добавить тип">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($types as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <form method="POST" action="{{ route('price-types.destroy', $item->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <a href="{{route('price-types.edit', $item->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить область"
                                            onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endcomponent
    @endcomponent
@endsection
