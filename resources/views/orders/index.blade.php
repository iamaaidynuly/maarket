@extends('adminlte::layout.main', ['title' => 'Заказы'])

@section('content')
    @component('adminlte::page', ['title' => 'Заказы'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{ url('/admin/orders/create') }}" class="btn btn-success btn-sm" title="Добавить заказ">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <a href="{{ url('/admin/export') }}" class="btn btn-info btn-sm" title="Выгрузка Excel">
                <i class="fa fa-cloud-upload" aria-hidden="true"></i> Выгрузка Excel
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>E-mail</th>
                        <th>Статус оплаты</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->email }}</td>
                            <td>@if(isset($item->pay_status) && $item->pay_status==1)
                                    {{ "Оплачено" }}
                                @else
                                    {{"Не оплачено"}}
                                @endif</td>
                            <td>
                                <a href="{{ url('admin/products-items/' . $item->id) }}" title="Редактировать продукт">
                                    <button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                        Редактировать продукт
                                    </button>
                                </a>
                                <a href="{{ url('/admin/orders/' . $item->id) }}" title="Просмотр заказа">
                                    <button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                        Просмотр
                                    </button>
                                </a>
                                <a href="{{ url('/admin/orders/' . $item->id . '/edit') }}" title="Редактировать заказ">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                              aria-hidden="true"></i> Редактировать
                                    </button>
                                </a>

                                <form method="POST" action="{{ url('/admin/orders' . '/' . $item->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить заказ"
                                            onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div
                    class="pagination-wrapper"> {!! $orders->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
