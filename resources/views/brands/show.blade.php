@extends('adminlte::layout.main', ['title' => 'Просмотр бренда'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр бренда'])
        @component('adminlte::box')
            <a href="{{ url('/admin/brands') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
            <a href="{{ url('/admin/brands/' . $brand->id . '/edit') }}" title="Редактировать бренд"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

            <form method="POST" action="{{ url('admin/brands' . '/' . $brand->id) }}" accept-charset="UTF-8" style="display:inline">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger btn-sm" title="Удалить бренд" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
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
                            <th>ID</th><td>{{ $brand->id }}</td>
                        </tr>
                        <tr><th> Наименование </th><td> {{ $brand->getTitle->ru }} </td></tr><tr><th> Описание </th><td> {{ $brand->getContent->ru }} </td></tr>
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
                            <th>ID</th><td>{{ $brand->id }}</td>
                        </tr>
                        <tr><th> Наименование </th><td> {{ $brand->getTitle->en }} </td></tr><tr><th> Описание </th><td> {{ $brand->getContent->en }} </td></tr></tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                Контент KZ
                            </th>
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>ID</th><td>{{ $brand->id }}</td>
                        </tr>
                        <tr><th> Наименование </th><td> {{ $brand->getTitle->kz }} </td></tr><tr><th> Описание </th><td> {{ $brand->getContent->kz }} </td></tr></tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th> Логотип </th>
                            <td> <img src="{{ \Config::get('constants.alias.cdn_url').$brand->image }}" alt="" style="max-width: 500px;"> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endcomponent
    @endcomponent
@endsection
