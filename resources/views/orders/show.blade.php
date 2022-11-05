@extends('adminlte::layout.main', ['title' => 'Просмотр заказа'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр заказа'])
        @component('adminlte::box')
            <div class="col-md-12">

                <a href="{{ url('/admin/orders') }}" title="Назад">
                    <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад
                    </button>
                </a>
                <a href="{{ url('/admin/orders/' . $order->id . '/edit') }}" title="Редатировать заказ">
                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Редактировать
                    </button>
                </a>

                <form method="POST" action="{{ url('admin/orders' . '/' . $order->id) }}" accept-charset="UTF-8"
                      style="display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить заказ"
                            onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o"
                                                                                          aria-hidden="true"></i>
                        Удалить
                    </button>
                </form>
                <br/>
                <br/>
                @if ($user)
                    <p style="font-weight:bold;font-size: 18pt">Данные пользователя</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th width="400px"> Имя</th>
                                <td> {{ $user->name }} </td>
                            </tr>
                            <tr>
                                <th> E-mail</th>
                                <td> {{ $user->email }} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
                <p style="font-weight:bold;font-size: 18pt">Информация о заказе</p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th width="400px">ID</th>
                            <td>{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <th width="400px"> Имя</th>
                            <td> {{ $order->name }} </td>
                        </tr>
                        <tr>
                            <th width="400px"> Фамилия</th>
                            <td> {{ $order->l_name }} </td>
                        </tr>
                        <tr>
                            <th> Телефон</th>
                            <td> {{ $order->phone }} </td>
                        </tr>
                        <tr>
                            <th> E-mail</th>
                            <td> {{ $order->email }} </td>
                        </tr>
                        <tr>
                            <th> Комментарий</th>
                            <td> {{ $order->comment }} </td>
                        </tr>
                        <tr>
                            <th> Статус заказа</th>
                            <td> {{ $order->getType->getName->ru }} </td>
                        </tr>
                        <tr>
                            <th> Статус оплаты</th>
                            <td>
                                @if($order->pay_status == true)
                                    Оплачено
                                @else
                                    Нет
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Промокод</th>
                            <td>
                                @if($order->promocode != null)
                                    {{$order->promocode}}
                                @else
                                    Без промокода
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Способ оплаты:</th>
                            <td>
                                @if($order->pay_method)
                                    Онлайн
                                @else
                                    Наличными
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Общая сумма</th>
                            <td>{{$order->total_price}}</td>
                        </tr>
                        <tr>
                            <th>Срок доставки:</th>
                            <td>
                                {{$order->date}}
                            </td>
                        </tr>
                        <tr>
                            <th>Способ доставки:</th>
                            <td>
                                @if($order->delivery == 'delivery')
                                    Доставка
                                @else
                                    Самовывоз
                                @endif
                            </td>
                        </tr>
                        @if ($adress)
                            <tr>
                                <th> Область</th>
                                <td> {{ \App\Models\Translate::where('id' , \App\Models\Region::where('id', $adress->region)->value('title'))->value('ru') }} </td>
                            </tr>
                            <tr>
                                <th> Город</th>
                                <td> {{ \App\Models\Translate::where('id' , \App\Models\City::where('id', $adress->city)->value('title'))->value('ru') }} </td>
                            </tr>
                            <tr>
                                <th> Улица</th>
                                <td> {{ $adress->street }} </td>
                            </tr>
                            <tr>
                                <th> Дом</th>
                                <td> {{ $adress->house }} </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <p style="font-weight:bold;font-size: 18pt">Товары</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Количество товара</th>
                            <th>Цена</th>
                            <th>Акция 1</th>
                            <th>Акция 2</th>
                            <th>Акция 1(бонус)</th>
                            <th>Акция 2(бонус)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order_products as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->count }}</td>
                                <td>{{ $item->price }}</td>
                                <td>
                                    @if($item->funds_1 == true)
                                        +
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($item->funds_2 == true)
                                        +
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ ($item->funds_1_bonus > 0) ? $item->funds_1_bonus : 0 }}</td>
                                <td>{{ ($item->funds_2_bonus > 0) ? $item->funds_2_bonus : 0 }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
