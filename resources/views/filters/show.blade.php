@extends('adminlte::layout.main', ['title' => 'Просмотр фильтра'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр фильтра'])
        @component('adminlte::box')
            <div class="col-md-12">
                <a href="{{ url('/admin/filters') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <a href="{{ url('/admin/filters/' . $filter->id . '/edit') }}" title="Редактировать фильтр"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                <form method="POST" action="{{ url('admin/filters' . '/' . $filter->id) }}" accept-charset="UTF-8" style="display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить фильтр" onclick="return confirm(&quot;подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                </form>
                <br/>
                <br/>
                <h4>Контент Ru</h4>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>ID</th><td>{{ $filter->id }}</td>
                            </tr>
                            <tr><th> Наименование </th><td> {{ $filter->getTitle->ru }} </td></tr>
                            @foreach($filter->getItems as $item)
                            <tr><th> Значение #{{ $loop->iteration }}</th><td> {{ $item->getTitle->ru }} </td></tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <br>
                <h4>Контент En</h4>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>ID</th><td>{{ $filter->id }}</td>
                            </tr>
                            <tr><th> Наименование </th><td> {{ $filter->getTitle->en }} </td></tr>
                            @foreach($filter->getItems as $item)
                            <tr><th> Значение #{{ $loop->iteration }}</th><td> {{ $item->getTitle->en }} </td></tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <br>
                <h4>Контент Kz</h4>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>ID</th><td>{{ $filter->id }}</td>
                            </tr>
                            <tr><th> Наименование </th><td> {{ $filter->getTitle->kz }} </td></tr>
                            @foreach($filter->getItems as $item)
                            <tr><th> Значение #{{ $loop->iteration }}</th><td> {{ $item->getTitle->kz }} </td></tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
            @endcomponent
    @endcomponent
@endsection
