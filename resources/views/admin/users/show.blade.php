@extends('adminlte::layout.main', ['title' => 'Просмотр пользователя'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр пользователя'])
        @component('adminlte::box')
            <div class="col-md-12">

                <a href="{{ route('users.index') }}" title="Назад">
                    <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад
                    </button>
                </a>
                <a href="{{ route('users.edit', $user->id) }}" title="Редактировать заказ">
                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Редактировать
                    </button>
                </a>

                <form method="POST" action="{{ route('users.destroy', $user->id) }}" accept-charset="UTF-8"
                      style="display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить заказ"
                            onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o"
                                                                                          aria-hidden="true"></i>
                        Удалить
                    </button>
                </form>
                <a href="{{route('user-export-date', $user->id)}}">
                    <button class="btn btn-success btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Отчет по дате
                    </button>
                </a>
                <br/>
                <br/>
                @if ($user)
                    <p style="font-weight:bold;font-size: 18pt">Данные пользователя</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th width="400px"> ФИО</th>
                                <td> {{ $user->name }} {{ $user->sname }} {{$user->lname}}</td>
                            </tr>
                            <tr>
                                <th> E-mail</th>
                                <td> {{ $user->email }} </td>
                            </tr>
                            <tr>
                                <th>Номер</th>
                                <td> {{ $user->phone_number }}</td>
                            </tr>
                            <tr>
                                <th>Дата регистрации</th>
                                <td> {{ $user->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Актуальный адрес</th>
                                <td>{{ $user->actual_address }}</td>
                            </tr>
                            <tr>
                                <th>Юр.адрес</th>
                                <td>{{$user->entity_address}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
                @if(isset($addresses))
                    <p style="font-weight:bold;font-size: 18pt">Адреса </p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead">
                            <tr>
                                <th>#</th>
                                <th>Регион</th>
                                <th>Город</th>
                                <th>Адрес</th>
                                <th>Номер</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($addresses as $address)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$address->getRegion->getTitle->ru}}</td>
                                    <td>{{$address->getCity->getTitle->ru}}</td>
                                    <td>{{$address->address}}</td>
                                    <td>{{$address->apartment}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if(isset($favs))
                    <p style="font-weight:bold;font-size: 18pt">Любимые продукты</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead">
                            <tr>
                                <th>#</th>
                                <th>Категория</th>
                                <th>Название</th>
                                <th>Цена</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($favs as $fav)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$fav->getProduct->getCategory->getTitle->ru}}</td>
                                    <td>{{$fav->getProduct->getTitle->ru}}</td>
                                    <td>{{$fav->getProduct->price}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                {{--                <div class="table-responsive">--}}
                {{--                    <table class="table">--}}
                {{--                        <tbody>--}}
                {{--                        <tr>--}}
                {{--                            <th width="400px"> Имя</th>--}}
                {{--                            <td> {{ $order->name }} </td>--}}
                {{--                        </tr>--}}
                {{--                        <tr>--}}
                {{--                            <th width="400px"> Фамилия</th>--}}
                {{--                            <td> {{ $order->l_name }} </td>--}}
                {{--                        </tr>--}}
                {{--                        <tr>--}}
                {{--                            <th> Телефон</th>--}}
                {{--                            <td> {{ $order->phone }} </td>--}}
                {{--                        </tr>--}}
                {{--                        <tr>--}}
                {{--                            <th> E-mail</th>--}}
                {{--                            <td> {{ $order->email }} </td>--}}
                {{--                        </tr>--}}
                {{--                        <tr>--}}
                {{--                            <th> Комментарий</th>--}}
                {{--                            <td> {{ $order->comment }} </td>--}}
                {{--                        </tr>--}}
                {{--                        <tr>--}}
                {{--                            <th> Статус заказа</th>--}}
                {{--                            <td> {{ $order->getType->getName->ru }} </td>--}}
                {{--                        </tr>--}}
                {{--                        <tr>--}}
                {{--                            <th> Статус оплаты</th>--}}
                {{--                            <td>--}}
                {{--                                @if($order->pay_status == true)--}}
                {{--                                    Оплачено--}}
                {{--                                @else--}}
                {{--                                    Нет--}}
                {{--                                @endif--}}
                {{--                            </td>--}}
                {{--                        </tr>--}}
                {{--                        <tr>--}}
                {{--                            <th>Способ оплаты:</th>--}}
                {{--                            <td>--}}
                {{--                                @if($order->pay_method)--}}
                {{--                                    Онлайн--}}
                {{--                                @else--}}
                {{--                                    Наличными--}}
                {{--                                @endif--}}
                {{--                            </td>--}}
                {{--                        </tr>--}}
                {{--                        <tr>--}}
                {{--                            <th>Общая сумма</th>--}}
                {{--                            <td>{{$order->total_price}}</td>--}}
                {{--                        </tr>--}}
                {{--                        <tr>--}}
                {{--                            <th>Срок доставки:</th>--}}
                {{--                            <td>--}}
                {{--                                {{$order->date}}--}}
                {{--                            </td>--}}
                {{--                        </tr>--}}
                {{--                        <tr>--}}
                {{--                            <th>Способ доставки:</th>--}}
                {{--                            <td>--}}
                {{--                                @if($order->delivery == 'delivery')--}}
                {{--                                    Доставка--}}
                {{--                                @else--}}
                {{--                                    Самовывоз--}}
                {{--                                @endif--}}
                {{--                            </td>--}}
                {{--                        </tr>--}}
                {{--                        @if ($adress)--}}
                {{--                            <tr>--}}
                {{--                                <th> Область</th>--}}
                {{--                                <td> {{ \App\Models\Translate::where('id' , \App\Models\Region::where('id', $adress->region)->value('title'))->value('ru') }} </td>--}}
                {{--                            </tr>--}}
                {{--                            <tr>--}}
                {{--                                <th> Город</th>--}}
                {{--                                <td> {{ \App\Models\Translate::where('id' , \App\Models\City::where('id', $adress->city)->value('title'))->value('ru') }} </td>--}}
                {{--                            </tr>--}}
                {{--                            <tr>--}}
                {{--                                <th> Улица</th>--}}
                {{--                                <td> {{ $adress->street }} </td>--}}
                {{--                            </tr>--}}
                {{--                            <tr>--}}
                {{--                                <th> Дом</th>--}}
                {{--                                <td> {{ $adress->house }} </td>--}}
                {{--                            </tr>--}}
                {{--                        @endif--}}
                {{--                        </tbody>--}}
                {{--                    </table>--}}
                {{--                </div>--}}
            </div>
        @endcomponent
    @endcomponent
@endsection
