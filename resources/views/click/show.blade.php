@extends('adminlte::layout.main', ['title' => 'Просмотр'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр'])
        @component('adminlte::box')
            <div class="col-md-12">

                        <a href="{{ url('/admin/click') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                        {{-- <a href="{{ url('/admin/click/' . $click->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                        <form method="POST" action="{{ url('/admin/click' . '/' . $click->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm(&quot;Подтвердите удаление?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                        </form> --}}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $click->id }}</td>
                                    </tr>
                                    <tr><th> Номер телефона </th><td> {{ $click->phone_number }} </td></tr><tr><th> Наименование продукта </th><td> {{ $product->title }} </td></tr><tr><th> Артикул </th><td> {{ $product->artikul }} </td></tr>
                                </tbody>
                            </table>
                        </div>

            </div>
        @endcomponent
    @endcomponent
@endsection
