<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Order;

class OrderSheet implements FromQuery, WithTitle, ShouldAutoSize, WithHeadings
{
    var $ot;
    var $do;

    function __construct($ot, $do)
    {
        $this->ot = $ot;
        $this->do = $do;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Дата заказа',
            'Имя',
            'Фамилия',
            'Номер',
            'Почта',
            'Статус оплаты',
            'Cтатус',
            'Артикул',
            'Наименование товара',
            'Количество',
            'Общая сумма',
            'Акция 1',
            'Акция 2',
            'Акция 1(бонус)',
            'Акция 2(бонус)',
            'Способ доставки',
            'Комментарии',
        ];
    }

    public function query()
    {
        return Order::join('order_products', 'order_products.order_id', 'orders.id')
            ->join('products', 'products.id', 'order_products.product_id')
            ->join('translates', 'translates.id', 'products.title')
            ->select('orders.id', 'orders.created_at', 'orders.name', 'orders.l_name', 'orders.phone', 'orders.email','orders.pay_status','orders.status','products.artikul', 'translates.ru', 'order_products.count', 'orders.total_price', 'order_products.funds_1','order_products.funds_2', 'order_products.funds_1_bonus', 'order_products.funds_2_bonus', 'orders.delivery', 'orders.comment')
            ->where('orders.created_at', '>=', date($this->ot) . ' 00:00:00')
            ->where('orders.created_at', '<=', date($this->do) . ' 00:00:00');
    }

    public function title(): string
    {
        return 'Заказы';
    }
}
