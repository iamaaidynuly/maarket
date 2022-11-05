@extends('adminlte::layout.main', ['title' => 'Просмотр'])
@section('content')
    @component('adminlte::page', ['title' => 'Просмотр'])
        @component('adminlte::box')
            @include('flash-message')
                <div class="card-body">

                        <a href="{{ url('/admin/status-types') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                        <a href="{{ url('/admin/status-types/' . $statustype->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                        <form method="POST" action="{{ url('/admin/status-types' . '/' . $statustype->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm(&quot;Подтвердите удаление?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
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
                                        <th>ID</th><td>{{ $statustype->id }}</td>
                                    </tr>
                                    <tr><th> Имя </th><td> {{ $statustype->getName->ru }} </td></tr>
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
                                        <th>ID</th><td>{{ $statustype->id }}</td>
                                    </tr>
                                    <tr><th> Имя </th><td> {{ $statustype->getName->en }} </td></tr>
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
                                        <th>ID</th><td>{{ $statustype->id }}</td>
                                    </tr>
                                    <tr><th> Имя </th><td> {{ $statustype->getName->kz }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                </div>
        @endcomponent
    @endcomponent
@endsection