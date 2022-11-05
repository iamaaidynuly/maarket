@extends('adminlte::layout.main', ['title' => 'Цены товара'])

@section('content')
    @component('adminlte::page', ['title' => 'Цены товара'])
        @component('adminlte::box')
            <a href="{{ url('/admin/product') }}" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</a>
            <a href="{{ route('create-price-type', $product->id) }}" class="btn btn-success btn-sm">Добавить новый</a>

            {{--            <form action="{{route('create-price-type')}}" class="form-group" method="get">--}}
            {{--                @method('get')--}}
            {{--                @csrf--}}
            {{--                <a href="{{ url('/admin/product') }}" title="Назад" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</a>--}}
            {{--                <input type="hidden" name="product" id="product" value="{{$product->id}}">--}}
            {{--                <button class="btn btn-success btn-sm" type="submit">Создать новый</button>--}}
            {{--            </form>--}}
            <br/>
            @include('flash-message')
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div id="for_sort" class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Тип</th>
                        <th>Цена</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prices as $price)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $price->name->name }}</td>
                            <td>{{ $price->price }}</td>
                            <td>
                                <form method="POST" action="{{ route('destroy-price-type', $price->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить страну"
                                            onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @endcomponent
    @endcomponent

@endsection
