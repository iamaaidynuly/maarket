@extends('adminlte::layout.main', ['title' => 'Слайдер'])

@section('content')
    @component('adminlte::page', ['title' => 'Слайдер'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{ url('/admin/slider/create') }}" class="btn btn-success btn-sm" title="Добавить слайд">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Изображение</th>
                        <th>Деиствия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($slider as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ \Config::get('constants.alias.cdn_url').$item->image }}" alt=""
                                     style="max-width: 150px;"></td>
                            <td>
                                <a href="{{ url('/admin/slider/' . $item->id) }}" title="Посотртеть слайд">
                                    <button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                        Просмотр
                                    </button>
                                </a>
                                <a href="{{ url('/admin/slider/' . $item->id . '/edit') }}" title="Редактировать слайд">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"
                                                                              aria-hidden="true"></i> Редактировать
                                    </button>
                                </a>

                                <form method="POST" action="{{ url('/admin/slider' . '/' . $item->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить слайд"
                                            onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i
                                            class="fa fa-trash-alt" aria-hidden="true"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div
                    class="pagination-wrapper"> {!! $slider->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
