@extends('adminlte::layout.main', ['title' => 'Просмотр'])
@section('content')
    @component('adminlte::page', ['title' => 'Просмотр'])
        @component('adminlte::box')
            @include('flash-message')
                    <div class="card-body">


                        <a href="{{ url('/admin/reviews') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                        <a href="{{ url('/admin/reviews/' . $review->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                        <form method="POST" action="{{ url('reviews' . '/' . $review->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm(&quot;Подтвердите удаление?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $review->id }}</td>
                                    </tr>
                                    <tr><th> Имя </th><td> {{ $review->name }} </td></tr><tr><th> Отзыв </th><td> {{ $review->review }} </td></tr><tr><th> Рейтинг </th><td> {{ $review->rating }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
        @endcomponent
    @endcomponent
@endsection
