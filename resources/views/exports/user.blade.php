<table>
    <thead>
    <tr>
        <th>Пользователь ID</th>
        <th>Пользователь</th>
        <th>Заказ ID</th>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Номер</th>
        <th>Логин</th>
        <th>Комментарии</th>
        <th>Доставка</th>
        <th>Тип оплаты</th>
        <th>Дата</th>
        <th>Статус</th>
        <th>Статус оплаты</th>
        <th>Цена</th>
        <th>Промокод</th>
    </tr>
    </thead>
    <tbody>

    @foreach($orders as $order)
        <tr>
            <td>{{ $order->user_id }}</td>
            <td>{{ \App\Models\User::find($order->user_id)->name }} {{ \App\Models\User::find($order->user_id)->sname }}</td>
            <td>{{ $order->id }}</td>
            <td>{{ $order->name }}</td>
            <td>{{ $order->l_name }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->email }}</td>
            <td>{{ $order->comment }}</td>
            <td>
                @if($order->delivery == 'delivery')
                    Доставка
                @else
                    Самовывоз
                @endif
            </td>
            <td>
                @if($order->pay_method == 'online')
                    Онлайн
                @else
                    Наличными
                @endif
            </td>
            <td>{{ $order->date }}</td>
            <td>{{ $order->getType->getName->ru}}</td>
            <td>
                @if($order->pay_status)
                    Неоплачен
                @else
                    Оплачено
                @endif
            </td>
            <td>{{ $order->total_price }}</td>
            <td>
                @if($order->promocode != null)
                    {{$order->promocode}}
                @elseif($order->promocode == "null")
                    -
                @else
                    -
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
