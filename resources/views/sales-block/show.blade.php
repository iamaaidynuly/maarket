@extends('adminlte::layout.main', ['title' => 'Просмотр блока'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр блока'])
        @component('adminlte::box')

                        <a href="{{ url('/admin/sales-block') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                        <a href="{{ url('/admin/sales-block/' . $salesblock->id . '/edit') }}" title="Редактировать блок"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                        <form method="POST" action="{{ url('admin/salesblock' . '/' . $salesblock->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Удлить блок" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Контент RU
                                        </th>
                                    </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $salesblock->id }}</td>
                                    </tr>
                                    <tr><th> Заголовок </th><td> {{ $salesblock->getTitle->ru }} </td></tr><tr><th> Описание </th><td> {{ $salesblock->getContent->ru }} </td></tr>
                                    <tr><th> Ссылка </th><td> {{ $salesblock->getUrl->ru }} </td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Контент EN
                                        </th>
                                    </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $salesblock->id }}</td>
                                    </tr>
                                    <tr><th> Заголовок </th><td> {{ $salesblock->getTitle->en }} </td></tr><tr><th> Описание </th><td> {{ $salesblock->getContent->en }} </td></tr>
                                    <tr><th> Ссылка </th><td> {{ $salesblock->getUrl->en }} </td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th> Изображение </th>
                                        <td> <img src="{{ \Config::get('constants.alias.cdn_url').$salesblock->image }}" alt="" style="max-width: 500px;"> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
@endcomponent
@endcomponent       
@endsection
