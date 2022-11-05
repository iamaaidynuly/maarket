@extends('adminlte::layout.main', ['title' => 'Рассылка'])

@section('content')
    @component('adminlte::page', ['title' => 'Рассылка'])
    @component('adminlte::box')
        @include('flash-message')
    
            <a href="{{ url('/admin/mail/create') }}" class="btn btn-success btn-sm" title="Добавить">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <a href="{{ url('/admin/export/export-excel_mail') }}" class="btn btn-info btn-sm" title="Загрузить Excel">
                <i class="fa fa-cloud-upload" aria-hidden="true"></i> Экспорт
            </a>
            <br/>
            <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Почта</th><th>Деиствия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($mail as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            <a href="{{ url('/admin/mail/' . $item->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                                            <form method="POST" action="{{ url('/admin/mail' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm(&quot;Подтвердите удаление?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $mail->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

    @endcomponent
    @endcomponent
@endsection
