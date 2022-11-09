@extends('adminlte::layout.main', ['title' => 'Просмотр магазина'])

@section('content')
    @component('adminlte::page', ['title' => "Просмотр магазина " . $shop->getName->ru])
        @component('adminlte::box')
            <div class="col-md-12">

                <a href="{{ route('shops.index') }}" title="Назад">
                    <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад
                    </button>
                </a>

                <br/>
                @if (isset($shop))
                    <p style="font-weight:bold;font-size: 18pt">Данные магазина</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th width="400px"> Название</th>
                                <td>
                                    {{$shop->getName->ru}}
                                </td>
                            </tr>
                            <tr>
                                <th> E-mail</th>
                                <td> {{ $shop->email }} </td>
                            </tr>
                            <tr>
                                <th>Дата регистрации</th>
                                <td> {{ $shop->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Адрес</th>
                                <td>{{ $shop->getAddress->ru }}</td>
                            </tr>
                            <tr>
                                <th>Описание</th>
                                <td>{{ $shop->getDescription->ru }}</td>
                            </tr>
                            <tr>
                                <th>Город</th>
                                <td>{{ $shop->getCity->getTitle->ru }}</td>
                            </tr>
                            <tr>
                                <th>Доставка</th>
                                <td>{{ $shop->getDelivery->ru }}</td>
                            </tr>
                            <tr>
                                <th>Мин.сумма</th>
                                <td>{{ $shop->getMinPrice->ru }}</td>
                            </tr>
                            <tr>
                                <th>Подтверждена:</th>
                                <td>{{ $shop->verified_at }}</td>
                            </tr>
                            <tr>
                                <th>Иконка:</th>
                                <td>
                                    @if(isset($shop->icon))
                                        <img src="{{ \Config::get('constants.alias.cdn_url') }}/{{ $shop->icon }}"
                                             alt=""
                                             style="max-width:100%">
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
                @if(isset($products))
                    <p style="font-weight:bold;font-size: 18pt">Товары магазина </p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead">
                            <tr>
                                <th>#</th>
                                <th>Продукт ID</th>
                                <th>Продукт</th>
                                <th>Цена</th>
                                <th>В наличии</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$product->product_id}}</td>
                                    <td>{{$product->product->getTitle->ru}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>{{$product->available}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endcomponent
    @endcomponent
@endsection
