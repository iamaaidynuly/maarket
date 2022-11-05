@extends('adminlte::layout.main', ['title' => 'Промокоды'])

@section('content')
    @component('adminlte::page', ['title' => 'Промокоды'])
        @component('adminlte::box')
            @include('flash-message')
            <div class="container">
                <div class="row">
                    <div class="col-6 col-md-6">
                        <form method="POST" action="{{route('promocode.store')}}" accept-charset="UTF-8"
                              class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @method('post')
                            <label for="">Промокод для авторизованного пользователя</label>
                            <input name="type" value="1" type="hidden">
                            <br>
                            <div class="row">
                                <div class="form-group col-md-4 ">
                                    <select name="user_id" id="user_id"
                                            class="form-control js-example-basic-single select2-hidden-accessible"
                                            required="" data-select2-id="select2-data-user_id" tabindex="-1"
                                            aria-hidden="true">
                                        <option value="" data-select2-id="select2-data-2-st8u">Выберите пользователя
                                        </option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}} {{$user->lname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2 ">
                                    <input class="form-control" name="code" type="text" id="code" value=""
                                           placeholder="Код" required>
                                </div>
                                <div class="form-group col-md-2 ">
                                    <input class="form-control" name="sale" type="text" id="sale" value=""
                                           placeholder="Процент%" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class="btn btn-primary" type="submit" value="Создать">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-6 col-md-6">
                        <form method="POST" action="{{ route('promocode.store') }}" accept-charset="UTF-8"
                              class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @method('post')
                            <label for="">Промокод для не авторизованного пользователя</label>
                            <input name="type" value="2" type="hidden">
                            <br>
                            <div class="row">
                                <div class="form-group col-md-5 ">
                                    <input class="form-control generated-code" name="code" type="text" id="code"
                                           value="" placeholder="Промокод">
                                </div>
                                <div class="form-group col-md-3 ">
                                    <input class="form-control generated-sale" name="sale" type="text"
                                           id="generated-sale" value="" placeholder="Процент%">
                                </div>
                                <div class="form-group col-md-4">
                                    <input class="btn btn-primary" type="submit" value="Создать">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-6 col-md-6">
                        <form method="GET" action="{{ url('/admin/promocode') }}" accept-charset="UTF-8"
                              class="form-inline my-2 my-lg-0 float-right" role="search" style="float: right;">
                            <label for="">Введите текст для поиска:</label><br>
                            <input type="text" class="form-control" name="search" placeholder="Поиск..."
                                   value="{{ request('search') }}">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
            <br/>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Промокод</th>
                        <th>Процент</th>
                        <th>Дата окончания</th>
                        <th>Тип</th>
                        <th>Пользователь</th>
                        <th>Активно</th>
                        <th>Деиствия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($promocode as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{$item->sale}}%</td>
                            <td>{{$item->exp_date}}</td>
                            <td>
                                @if($item->type == 1)
                                    Авторизованные
                                @else
                                    Неавторизованные
                                @endif
                            </td>
                            <td>
                                {{isset($item->user_id) ? $item->getUser->name . " " . $item->getUser->lname : null}}
                            </td>
                            <td>
                                @if($item->active == true)
                                    Да
                                @else
                                    Нет
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ url('/admin/promocode' . '/' . $item->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Promocode"
                                            onclick="return confirm(&quot;Confirm delete?&quot;)">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div
                    class="pagination-wrapper"> {!! $promocode->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
            $('.new-promo').click(function () {
                console.log($('.generated-sale').val());
                $.ajax({
                    url: "/admin/promocode/generate",
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        type: 'other',
                        sale: $('.generated-sale').val(),
                        exp_date: $('.generated-exp_date').val()
                    }
                }).done(function (message) {
                    console.log(message);
                    $('.generated-code').val(message);
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
            $('.new-promo-cert').click(function () {
                $.ajax({
                    url: "/admin/promocode/generate-cert",
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        type: 'cert',
                        sale_price: $('.generated-sale-cert').val(),
                        exp_date_cert: $('.generated-exp_date_cert').val()
                    }
                }).done(function (message) {
                    console.log(message);
                    $('.generated-code').val(message);
                });
                location.reload();
            });
        });
    </script>
@endpush
