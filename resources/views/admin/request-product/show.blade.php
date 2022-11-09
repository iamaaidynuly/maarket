@extends('adminlte::layout.main', ['title' => 'Просмотр заявки'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр заявки'])
        @component('adminlte::box')
            <div class="col-md-12">

                <a href="{{ route('request-products.index') }}" title="Назад">
                    <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад
                    </button>
                </a>

                <form method="POST" action="{{ route('request-products.destroy', $shopRequestProduct->id)  }}"
                      accept-charset="UTF-8"
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
                <p style="font-weight:bold;font-size: 18pt">Информация продукта</p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th width="400px">ID</th>
                            <td>{{ $shopRequestProduct->id }}</td>
                        </tr>
                        <tr>
                            <th>Магазин:</th>
                            <td>{{ $shopRequestProduct->shop->getName->ru }}</td>
                        </tr>
                        <tr>
                            <th width="400px"> Название</th>
                            <td> {{ $shopRequestProduct->getTitle->ru }} </td>
                        </tr>
                        <tr>
                            <th width="400px"> Описание</th>
                            <td> {{ $shopRequestProduct->getDescription->ru }} </td>
                        </tr>
                        <tr>
                            <th> Артикул</th>
                            <td> {{ $shopRequestProduct->artikul }} </td>
                        </tr>
                        <tr>
                            <th>Цена</th>
                            <td> {{ $shopRequestProduct->price }} </td>
                        </tr>
                        <tr>
                            <th> Бренд</th>
                            <td> {{ $shopRequestProduct->brand->getTitle->ru }} </td>
                        </tr>
                        <tr>
                            <th> Бренд подробнее</th>
                            <td> {{ $shopRequestProduct->brand_items->getTitle->ru }} </td>
                        </tr>
                        <tr>
                            <th>Страна</th>
                            <td>{{ $shopRequestProduct->country->getTitle->ru }}</td>
                        </tr>
                        <tr>
                            <th>Фильтры:</th>
                            <td>
                                @foreach($shopRequestProduct->filters as $filter)
                                    {{$filter->filter_item->getTitle->ru}}
                                    <br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Статус:</th>
                            <td style="font-weight: bold">
                                @if($shopRequestProduct->status == \App\Models\ShopRequestProduct::STATUS_IN_PROCESS)
                                    В процессе
                                @elseif($shopRequestProduct->status == \App\Models\ShopRequestProduct::STATUS_ACCEPTED)
                                    Принято
                                @else
                                    Отклонено
                                @endif
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            @if (isset($images))
                <br><br>
                <div class="row">
                    @foreach ($images as $item)
                        <div class="col-md-3">
                            <div class="img-wrapper" style="position:reklative">
                                <img src="{{ \Config::get('constants.alias.cdn_url') }}/{{ $item }}" alt=""
                                     style="max-width:100%">
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <br>
            @if($shopRequestProduct->status == \App\Models\ShopRequestProduct::STATUS_IN_PROCESS)
                <a href="{{ route('request-product-accept', $shopRequestProduct->id) }}">
                    <button class="btn btn-success btn-sm" onclick="return confirm(&quot;Подтвердите действие&quot;)">
                        Принять
                    </button>
                </a>
                <a href="{{ route('request-product-reject', $shopRequestProduct->id) }}">
                    <button class="btn btn-danger btn-sm" onclick="return confirm(&quot;Подтвердите отклонение&quot;)">
                        Отклонить
                    </button>
                </a>
            @endif
        @endcomponent
    @endcomponent
@endsection
