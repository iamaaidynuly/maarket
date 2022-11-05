@extends('adminlte::layout.main', ['title' => 'Новости'])

@section('content')
    @component('adminlte::page', ['title' => 'Новости'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{route('news.create')}}" class="btn btn-success btn-sm" title="Добавить">
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
                        <th>Описание</th>
                        <th>Просмотры</th>
                        <th>Картинка</th>
                        <th>Дата</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($news as $companyNew)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \App\Models\Translate::where('id', $companyNew->title)->value('ru') }}</td>
                            <td>{{ \App\Models\Translate::where('id', $companyNew->description)->value('ru') }}</td>
                            <td>{{ $companyNew->shows }}</td>
                            <td><img src="{{ \Config::get('constants.alias.cdn_url').$companyNew->image }}" alt=""
                                     style="max-width: 100px;"></td>
                            <td>{{ $companyNew->created_at }}</td>
                            <td>
                                <a href="{{route('news.edit', $companyNew->id)}}" title="Редактировать">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                              aria-hidden="true"></i> Редактировать
                                    </button>
                                </a>

                                <form method="POST" action="{{ route('news.destroy', $companyNew->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить"
                                            onclick="return confirm(&quot;Подтвердите удаление?&quot;)"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
{{--                <div class="pagination-wrapper"> {!! $reviews->appends(['search' => Request::get('search')])->render() !!} </div>--}}
            </div>
        @endcomponent
    @endcomponent
@endsection
