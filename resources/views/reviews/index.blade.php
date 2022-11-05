@extends('adminlte::layout.main', ['title' => 'Отзывы'])

@section('content')
    @component('adminlte::page', ['title' => 'Отзывы'])
        @component('adminlte::box')
            @include('flash-message')
                        <a href="{{ url('/admin/reviews/create') }}" class="btn btn-success btn-sm" title="Добавить">
                            <i class="fa fa-plus" aria-hidden="true"></i> Добавить
                        </a>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Имя</th><th>Отзыв</th><th>Рейтинг</th><th>Деиствия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($reviews as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->review }}</td><td>{{ $item->rating }}</td>
                                        <td>
                                            <a href="{{ url('/admin/reviews/' . $item->id) }}" title="Просмотр"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр</button></a>
                                            <a href="{{ url('/admin/reviews/' . $item->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                                            <form method="POST" action="{{ url('/admin/reviews' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm(&quot;Подтвердите удаление?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $reviews->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>
        @endcomponent
    @endcomponent             
@endsection
