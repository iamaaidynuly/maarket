@extends('adminlte::layout.main', ['title' => 'Блоги'])

@section('content')
    @component('adminlte::page', ['title' => 'Блоги'])
        @component('adminlte::box')
            @include('flash-message')
    
            <a href="{{ url('/admin/blogs/create') }}" class="btn btn-success btn-sm" title="Добавить блог">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th><th>Заголовок</th><th>Изображение</th><th>Настройка SEO</th><th>Деиствия</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($blogs as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->getTitle->ru }}</td><td><img src="{{ \Config::get('constants.alias.cdn_url').$item->image }}" alt="" style="max-width: 400px;"></td>
                            <td><a href="/admin/blogs/seo/{{ $item->id }}" class="btn btn-info">Заполнить SEO</a></td>
                            <td>
                                <a href="{{ url('/admin/blogs/' . $item->id) }}" title="Просмотр блога"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Посмотреть</button></a>
                                <a href="{{ url('/admin/blogs/' . $item->id . '/edit') }}" title="Редактировать блог"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                                <form method="POST" action="{{ url('/admin/blogs' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить блог" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $blogs->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
