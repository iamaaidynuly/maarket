@extends('adminlte::layout.main', ['title' => 'Просмотр'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр'])
        @component('adminlte::box')
            <div class="col-md-12">

                        <a href="{{ url('/admin/article') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                        <a href="{{ url('/admin/article/' . $article->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                        <form method="POST" action="{{ url('/admin/article' . '/' . $article->id) }}" accept-charset="UTF-8" style="display:inline">
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
                                </tr>
                            </thead>
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $article->id }}</td>
                                    </tr>
                                    <tr><th> Заголовок </th><td> {{ $article->getTitle->ru }} </td></tr><tr><th> Описание </th><td> {{ $article->getDescription->ru }} </td></tr>
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
                                </tr>
                            </thead>
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $article->id }}</td>
                                    </tr>
                                    <tr><th> Заголовок </th><td> {{ $article->getTitle->kz }} </td></tr><tr><th> Описание </th><td> {{ $article->getDescription->kz }} </td></tr>
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
                                </tr>
                            </thead>
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $article->id }}</td>
                                    </tr>
                                    <tr><th> Заголовок </th><td> {{ $article->getTitle->en }} </td></tr><tr><th> Описание </th><td> {{ $article->getDescription->en }} </td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th> Изображение </th>
                                        <td> <img src="{{ \Config::get('constants.alias.cdn_url').$article->image }}" alt="" style="max-width: 500px;"> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

            </div>
        @endcomponent
    @endcomponent
@endsection

