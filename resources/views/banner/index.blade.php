@extends('adminlte::layout.main', ['title' => 'Баннер'])

@section('content')
    @component('adminlte::page', ['title' => 'Баннер'])
    @component('adminlte::box')
        @include('flash-message')
    
            <a href="{{ url('/admin/banner/create') }}" class="btn btn-success btn-sm" title="Добавить">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th><th>Заголовок</th><th>Изображение(desktop)</th><th>Деиствия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banner as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->getTitle->ru }}</td>
                            <td><img src="{{ \Config::get('constants.alias.cdn_url').$item->image_desktop }}" alt="" style="max-width: 300px;"></td>
                            <td>
                                <a href="{{ url('/admin/banner/' . $item->id) }}" title="Посмотреть"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр</button></a>
                                <a href="{{ url('/admin/banner/' . $item->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                                <form method="POST" action="{{ url('/admin/banner' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
              
                    </tbody>
                </table>
                <div class="pagination-wrapper">  </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
